<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Trainer;
use App\Models\BillingLog;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = Member::count();
        $totalTrainers = Trainer::count();
        $paidBills   = BillingLog::where('status', 'paid')->count();
        $unpaidBills = BillingLog::where('status', 'unpaid')->count();
        $revenue     = BillingLog::where('status', 'paid')->sum('amount_due');

        return view('dashboard', compact(
            'totalMembers',
            'totalTrainers',
            'paidBills',
            'unpaidBills',
            'revenue'
        ));
    }
}