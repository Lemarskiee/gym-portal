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
}