<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PendingController extends Controller
{
    public function index()
    {
        $application = Auth::user()->trainerApplication;
        return view('auth.pending', compact('application'));
    }
}