<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use Illuminate\Http\Request;

class MembershipPlanController extends Controller
{
    public function index()
    {
        $plans = MembershipPlan::all();

        return view('plans.index', compact('plans'));
    }

    public function create()
    {
        return view('plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'duration_months' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        MembershipPlan::create([
            'name' => $request->name,
            'duration_months' => $request->duration_months,
            'price' => $request->price,
        ]);

        return redirect('/plans');
    }

    public function edit($id)
    {
        $plan = MembershipPlan::findOrFail($id);

        return view('plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $plan = MembershipPlan::findOrFail($id);
        
        $request->validate([
            'name' => 'required|max:255',
            'duration_months' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        $plan->update([
            'name' => $request->name,
            'duration_months' => $request->duration_months,
            'price' => $request->price,
        ]);

        return redirect('/plans');
    }

    public function destroy($id)
    {
        $plan = MembershipPlan::findOrFail($id);

        $plan->delete();

        return redirect('/plans');
    }
}