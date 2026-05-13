<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\MembershipPlan;
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
            'name'      => 'required|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
            'role'      => 'required|in:member,trainer',
            // Member-specific
            'membership_plan_id' => 'required_if:role,member',
            'phone'     => 'required|max:20',
            'start_date'=> 'required_if:role,member|nullable|date',
            // Trainer-specific
            'specialty' => 'required_if:role,trainer|nullable|max:255',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
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

            // Auto-create first billing log
            $plan = MembershipPlan::find($request->membership_plan_id);
            \App\Models\BillingLog::create([
                'member_id'     => $member->id,
                'billing_month' => now()->startOfMonth(),
                'amount_due'    => $plan->price,
                'due_date'      => now()->addDays(7),
                'status'        => 'unpaid',
            ]);
        }

        if ($request->role === 'trainer') {
            Trainer::create([
                'user_id'   => $user->id,
                'full_name' => $request->name,
                'specialty' => $request->specialty,
                'phone'     => $request->phone,
            ]);
        }

        Auth::login($user);

        return match ($user->role) {
            'member'  => redirect('/member/dashboard'),
            'trainer' => redirect('/trainer/dashboard'),
            default   => redirect('/'),
        };
    }
}