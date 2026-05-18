<?php

namespace App\Http\Controllers;

use App\Models\TrainerAssignment;
use App\Models\Member;
use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerAssignmentController extends Controller
{
    public function index()
    {
        $assignments = TrainerAssignment::with(['member', 'trainer'])->get();

        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        $members = Member::all();
        $trainers = Trainer::all();

        return view('assignments.create', compact('members', 'trainers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'trainer_id' => 'required',
            'assigned_from' => 'required|date',
            'assigned_to' => 'nullable|date'
        ]);

        TrainerAssignment::create($request->all());

        return redirect('/assignments');
    }

    public function edit($id)
    {
        $assignment = TrainerAssignment::findOrFail($id);

        $members = Member::all();
        $trainers = Trainer::all();

        return view('assignments.edit', compact(
            'assignment',
            'members',
            'trainers'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'member_id' => 'required',
            'trainer_id' => 'required',
            'assigned_from' => 'required|date',
            'assigned_to' => 'nullable|date'
        ]);
        
        $assignment = TrainerAssignment::findOrFail($id);

        $assignment->update($request->all());

        return redirect('/assignments');
    }

    public function destroy($id)
    {
        $assignment = TrainerAssignment::findOrFail($id);

        $assignment->delete();

        return redirect('/assignments');
    }

    // In TrainerAssignmentController — add this method
    public function fulfillRequest(Request $request, $requestId)
    {
        $request->validate([
            'trainer_id'    => 'required|exists:trainers,id',
            'assigned_from' => 'required|date',
            'assigned_to'   => 'nullable|date|after_or_equal:assigned_from',
        ]);

        $trainerRequest = \App\Models\TrainerRequest::findOrFail($requestId);

        \App\Models\TrainerAssignment::create([
            'member_id'     => $trainerRequest->member_id,
            'trainer_id'    => $request->trainer_id,
            'assigned_from' => $request->assigned_from,
            'assigned_to'   => $request->assigned_to,
        ]);

        $trainerRequest->update(['status' => 'fulfilled']);

        return redirect('/admin/trainer-requests')->with('success', 'Trainer assigned successfully.');
    }

    public function requests()
    {
        $trainerRequests = \App\Models\TrainerRequest::with('member.plan')
            ->orderByRaw("FIELD(status, 'pending', 'fulfilled', 'cancelled')")
            ->latest()
            ->get();

        $trainers = \App\Models\Trainer::all();

        return view('admin.trainer_requests', compact('trainerRequests', 'trainers'));
    }
}