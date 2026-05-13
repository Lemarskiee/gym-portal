<?php

namespace App\Http\Controllers;

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

        $billingLogs  = $member->billingLogs()->latest()->get();
        $assignments  = $member->trainerAssignments()->with('trainer')->get();
        $plan         = $member->plan;

        return view('member.dashboard', compact('member', 'billingLogs', 'assignments', 'plan'));
    }
}