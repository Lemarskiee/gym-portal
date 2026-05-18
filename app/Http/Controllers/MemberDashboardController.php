<?php

namespace App\Http\Controllers;

use App\Models\TrainerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $member = $user->member;

        if (!$member) {
            abort(404, 'No member profile linked to your account.');
        }

        $billingLogs     = $member->billingLogs()->latest()->get();
        $assignments     = $member->trainerAssignments()->with('trainer')->get();
        $trainerRequests = $member->trainerRequests()->latest()->get();
        $plan            = $member->plan;

        // Only show the "Request Trainer" form if they have no active pending request
        $hasPendingRequest = $trainerRequests->where('status', 'pending')->isNotEmpty();

        return view('member.dashboard', compact(
            'member',
            'billingLogs',
            'assignments',
            'trainerRequests',
            'plan',
            'hasPendingRequest'
        ));
    }

    public function payBill($billId)
    {
        $user   = Auth::user();
        $member = $user->member;

        // Scope to this member only — prevents paying other members' bills
        $bill = $member->billingLogs()->where('id', $billId)->firstOrFail();

        if ($bill->status === 'paid') {
            return back()->with('error', 'This bill has already been paid.');
        }

        $bill->update([
            'status'  => 'paid',
            'paid_at' => now()->toDateString(),
        ]);

        return back()->with('success', 'Payment confirmed! Bill marked as paid.');
    }

    public function requestTrainer(Request $request)
    {
        $user   = Auth::user();
        $member = $user->member;

        $request->validate([
            'preferred_specialty' => 'nullable|max:255',
            'message'             => 'nullable|max:1000',
        ]);

        // Prevent duplicate pending requests
        $alreadyPending = $member->trainerRequests()
            ->where('status', 'pending')
            ->exists();

        if ($alreadyPending) {
            return back()->with('error', 'You already have a pending trainer request.');
        }

        TrainerRequest::create([
            'member_id'           => $member->id,
            'preferred_specialty' => $request->preferred_specialty,
            'message'             => $request->message,
            'status'              => 'pending',
        ]);

        return back()->with('success', 'Trainer request submitted! An admin will assign one shortly.');
    }

    public function cancelRequest($requestId)
    {
        $user   = Auth::user();
        $member = $user->member;

        $trainerRequest = $member->trainerRequests()
            ->where('id', $requestId)
            ->where('status', 'pending')
            ->firstOrFail();

        $trainerRequest->update(['status' => 'cancelled']);

        return back()->with('success', 'Trainer request cancelled.');
    }
}