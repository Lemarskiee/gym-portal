@extends('layouts.app')

@section('content')
<div class="container-box">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Trainer Applications</h4>
        <span class="badge bg-warning text-dark fs-6">
            {{ $applications->where('status','pending')->count() }} Pending
        </span>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Specialty</th>
                <th>Phone</th>
                <th>Submitted</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($applications as $app)
            <tr>
                <td>{{ $app->full_name }}</td>
                <td>{{ $app->specialty }}</td>
                <td>{{ $app->phone }}</td>
                <td>{{ $app->created_at->format('M d, Y') }}</td>
                <td>
                    @if ($app->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif ($app->status === 'approved')
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
                <td>
                    <a href="/admin/applications/{{ $app->id }}"
                       class="btn btn-sm btn-outline-primary">Review</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No applications yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection