<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class TrainerDashboardController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $trainer = $user->trainer;

        if (!$trainer) {
            abort(404, 'No trainer profile linked to your account.');
        }

        $assignments = $trainer->assignments()->with('member.plan')->get();

        return view('trainer.dashboard', compact('trainer', 'assignments'));
    }
}