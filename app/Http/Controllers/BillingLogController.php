<?php

namespace App\Http\Controllers;

use App\Models\BillingLog;
use App\Models\Member;
use Illuminate\Http\Request;

class BillingLogController extends Controller
{
    public function index()
    {
        $billings = BillingLog::with('member')->get();

        return view('billing.index', compact('billings'));
    }

    public function create()
    {
        $members = Member::all();

        return view('billing.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'billing_month' => 'required|date',
            'amount_due' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required'
        ]);

        BillingLog::create($request->all());

        return redirect('/billing');
    }

    public function edit($id)
    {
        $billing = BillingLog::findOrFail($id);

        $members = Member::all();

        return view('billing.edit', compact('billing', 'members'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'member_id' => 'required',
            'billing_month' => 'required|date',
            'amount_due' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required'
        ]);

        $billing = BillingLog::findOrFail($id);

        $billing->update($request->all());

        return redirect('/billing');
    }

    public function destroy($id)
    {
        $billing = BillingLog::findOrFail($id);

        $billing->delete();

        return redirect('/billing');
    }
}