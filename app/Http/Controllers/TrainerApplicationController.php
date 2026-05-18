<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\TrainerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainerApplicationController extends Controller
{
    public function index()
    {
        $applications = TrainerApplication::with('user')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->latest()
            ->get();

        return view('admin.applications.index', compact('applications'));
    }

    public function show($id)
    {
        $application = TrainerApplication::with('user')->findOrFail($id);
        return view('admin.applications.show', compact('application'));
    }

    // Serve the license file securely (files are in private storage)
    public function license($id)
    {
        $application = TrainerApplication::findOrFail($id);
        $path = $application->license_file;

        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('private')->path($path));
    }

    public function approve($id)
    {
        $application = TrainerApplication::with('user')->findOrFail($id);

        // Create the actual Trainer record
        Trainer::create([
            'user_id'   => $application->user_id,
            'full_name' => $application->full_name,
            'specialty' => $application->specialty,
            'phone'     => $application->phone,
        ]);

        // Promote user role
        $application->user->update(['role' => 'trainer']);

        // Mark application approved
        $application->update(['status' => 'approved']);

        return redirect('/admin/applications')->with('success', "Trainer \"{$application->full_name}\" has been approved.");
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|max:500',
        ]);

        $application = TrainerApplication::with('user')->findOrFail($id);

        $application->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Optionally delete the user account on rejection, or just leave them locked out
        // $application->user->delete();

        return redirect('/admin/applications')->with('success', "Application rejected.");
    }
}