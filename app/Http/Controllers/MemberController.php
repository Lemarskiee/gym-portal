<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\BillingLog;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with('plan')->get();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        $plans = MembershipPlan::all();

        return view('members.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'membership_plan_id' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => 'required|max:20',
            'start_date' => 'required|date'
        ]);

        $member = Member::create($request->all());

        $plan = MembershipPlan::find($member->membership_plan_id);

        BillingLog::create([
            'member_id' => $member->id,
            'billing_month' => now()->startOfMonth(),
            'amount_due' => $plan->price,
            'due_date' => now()->addDays(7),
            'status' => 'unpaid',
        ]);

        return redirect('/members');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $plans = MembershipPlan::all();

        return view('members.edit', compact('member', 'plans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'membership_plan_id' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required|max:20',
            'start_date' => 'required|date'
        ]);
        
        $member = Member::findOrFail($id);

        $member->update($request->all());

        return redirect('/members');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        $member->delete();

        return redirect('/members');
    }
}