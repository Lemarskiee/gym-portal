@extends('layouts.app')

@section('content')
<div class="container-box" style="max-width: 680px; margin: auto;">

    <a href="/admin/applications" class="btn btn-outline-secondary btn-sm mb-4">
        ← Back to Applications
    </a>

    <h4 class="mb-4">Application — {{ $application->full_name }}</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mb-4">
        <tr><th>Full Name</th>  <td>{{ $application->full_name }}</td></tr>
        <tr><th>Email</th>      <td>{{ $application->user->email }}</td></tr>
        <tr><th>Phone</th>      <td>{{ $application->phone }}</td></tr>
        <tr><th>Specialty</th>  <td>{{ $application->specialty }}</td></tr>
        <tr><th>Submitted</th>  <td>{{ $application->created_at->format('M d, Y h:i A') }}</td></tr>
        <tr>
            <th>Status</th>
            <td>
                @if ($application->status === 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                @elseif ($application->status === 'approved')
                    <span class="badge bg-success">Approved</span>
                @else
                    <span class="badge bg-danger">Rejected</span>
                    @if ($application->rejection_reason)
                        <p class="mt-1 mb-0 text-danger">{{ $application->rejection_reason }}</p>
                    @endif
                @endif
            </td>
        </tr>
        <tr>
            <th>License / Proof</th>
            <td>
                <a href="/admin/applications/{{ $application->id }}/license"
                   target="_blank" class="btn btn-sm btn-outline-dark">
                    View Document
                </a>
            </td>
        </tr>
    </table>

    @if ($application->status === 'pending')

        {{-- APPROVE --}}
        <form method="POST" action="/admin/applications/{{ $application->id }}/approve"
              class="d-inline me-2">
            @csrf
            <button class="btn btn-success"
                    onclick="return confirm('Approve this trainer?')">
                ✅ Approve
            </button>
        </form>

        {{-- REJECT --}}
        <button class="btn btn-danger" data-bs-toggle="collapse"
                data-bs-target="#rejectForm">
            ❌ Reject
        </button>

        <div id="rejectForm" class="collapse mt-3">
            <form method="POST" action="/admin/applications/{{ $application->id }}/reject">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Rejection Reason</label>
                    <textarea name="rejection_reason" class="form-control" rows="3"
                              placeholder="Explain why the application is rejected..."
                              required></textarea>
                </div>
                <button type="submit" class="btn btn-danger">Confirm Rejection</button>
            </form>
        </div>

    @endif

</div>
@endsection