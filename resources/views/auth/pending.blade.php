@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="container-box text-center">

            <div style="font-size: 56px;">⏳</div>
            <h4 class="mt-3 mb-2">Application Under Review</h4>

            <p class="text-muted">
                Your trainer application has been submitted and is currently being reviewed by our admin team.
                You'll have full access to the platform once approved.
            </p>

            @if ($application)
                <table class="table table-bordered text-start mt-4">
                    <tr>
                        <th>Name</th>
                        <td>{{ $application->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Specialty</th>
                        <td>{{ $application->specialty }}</td>
                    </tr>
                    <tr>
                        <th>Submitted</th>
                        <td>{{ $application->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($application->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending Review</span>
                            @elseif ($application->status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                                @if ($application->rejection_reason)
                                    <p class="text-danger mt-2 mb-0">
                                        <strong>Reason:</strong> {{ $application->rejection_reason }}
                                    </p>
                                @endif
                            @endif
                        </td>
                    </tr>
                </table>
            @endif

            <form method="POST" action="/logout" class="mt-3">
                @csrf
                <button class="btn btn-outline-secondary">Logout</button>
            </form>

        </div>
    </div>
</div>
@endsection