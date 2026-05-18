<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\TrainerApplication;
use App\Models\BillingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        $plans = MembershipPlan::all();
        return view('auth.register', compact('plans'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'               => 'required|max:255',
            'email'              => 'required|email|unique:users,email',
            'password'           => 'required|min:8|confirmed',
            'role'               => 'required|in:member,trainer',
            'phone'              => 'required|max:20',
            // Member-specific
            'membership_plan_id' => 'required_if:role,member',
            'start_date' => [
                'required_if:role,member',
                'nullable',
                'date',
                'after_or_equal:today',
            ],
            // Trainer-specific
            'specialty'          => 'required_if:role,trainer|nullable|max:255',
            'license_file'       => 'required_if:role,trainer|nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        // Trainers are pending until admin approves
        $assignedRole = $request->role === 'trainer' ? 'pending_trainer' : 'member';

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $assignedRole,
        ]);

        if ($request->role === 'member') {
            $member = Member::create([
                'user_id'            => $user->id,
                'membership_plan_id' => $request->membership_plan_id,
                'first_name'         => explode(' ', $request->name)[0],
                'last_name'          => implode(' ', array_slice(explode(' ', $request->name), 1)) ?: '-',
                'email'              => $request->email,
                'phone'              => $request->phone,
                'start_date'         => $request->start_date,
            ]);

            $plan = MembershipPlan::find($request->membership_plan_id);
            BillingLog::create([
                'member_id'     => $member->id,
                'billing_month' => now()->startOfMonth(),
                'amount_due'    => $plan->price,
                'due_date'      => now()->addDays(7),
                'status'        => 'unpaid',
            ]);
        }

        if ($request->role === 'trainer') {
            // Store the uploaded license file
            $path = $request->file('license_file')->store('licenses', 'private');

            TrainerApplication::create([
                'user_id'      => $user->id,
                'full_name'    => $request->name,
                'specialty'    => $request->specialty,
                'phone'        => $request->phone,
                'license_file' => $path,
                'status'       => 'pending',
            ]);
        }

        Auth::login($user);

        return match ($assignedRole) {
            'member'          => redirect('/member/dashboard'),
            'pending_trainer' => redirect('/pending'),
            default           => redirect('/'),
        };
    }
}