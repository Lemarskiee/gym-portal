<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::all();

        return view('trainers.index', compact('trainers'));
    }

    public function create()
    {
        return view('trainers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|max:255',
            'specialty' => 'required|max:255',
            'phone' => 'required|max:20'
        ]);

        Trainer::create($request->all());

        return redirect('/trainers');
    }

    public function edit($id)
    {
        $trainer = Trainer::findOrFail($id);

        return view('trainers.edit', compact('trainer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|max:255',
            'specialty' => 'required|max:255',
            'phone' => 'required|max:20'
        ]);

        $trainer = Trainer::findOrFail($id);

        $trainer->update($request->all());

        return redirect('/trainers');
    }

    public function destroy($id)
    {
        $trainer = Trainer::findOrFail($id);

        $trainer->delete();

        return redirect('/trainers');
    }
}