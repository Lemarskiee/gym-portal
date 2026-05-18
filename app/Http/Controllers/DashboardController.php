<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Trainer;
use App\Models\BillingLog;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $statusFilter = $request->get('status');
        $planFilter = $request->get('plan_id');

        $totalMembers = Member::count();
        $totalTrainers = Trainer::count();
        $paidBills   = BillingLog::where('status', 'paid')->count();
        $unpaidBills = BillingLog::where('status', 'unpaid')->count();
        $revenue     = BillingLog::where('status', 'paid')->sum('amount_due');

        // Chart data - billing by month
        $billingByMonth = BillingLog::selectRaw('MONTH(created_at) as month, SUM(amount_due) as total')
            ->where('status', 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Members by plan
        $membersByPlan = MembershipPlan::withCount('members')->get();

        // Recent members with search and filter
        $recentMembers = Member::with('membershipPlan')
            ->when($search, function($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            })
            ->when($planFilter, function($q) use ($planFilter) {
                $q->where('membership_plan_id', $planFilter);
            })
            ->latest()
            ->take(10)
            ->get();

        $plans = MembershipPlan::all();

        return view('dashboard', compact(
            'totalMembers', 'totalTrainers', 'paidBills',
            'unpaidBills', 'revenue', 'billingByMonth',
            'membersByPlan', 'recentMembers', 'plans',
            'search', 'statusFilter', 'planFilter'
        ));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $members = Member::with('membershipPlan')
            ->where('first_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->take(6)
            ->get()
            ->map(fn($m) => [
                'name' => $m->first_name . ' ' . $m->last_name,
                'email' => $m->email,
                'plan' => $m->membershipPlan->name ?? 'N/A'
            ]);

        return response()->json($members);
    }
}