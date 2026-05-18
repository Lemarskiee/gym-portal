@extends('layouts.app')

@section('content')
<div class="container-box">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Trainer Requests</h4>
        <span class="badge bg-warning text-dark fs-6">
            {{ $trainerRequests->where('status','pending')->count() }} Pending
        </span>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Member</th>
                <th>Plan</th>
                <th>Specialty Requested</th>
                <th>Message</th>
                <th>Status</th>
                <th>Submitted</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($trainerRequests as $req)
            <tr>
                <td class="fw-semibold">
                    {{ $req->member->first_name }} {{ $req->member->last_name }}
                </td>
                <td>{{ $req->member->plan->name ?? '—' }}</td>
                <td>{{ $req->preferred_specialty ?? 'Any' }}</td>
                <td>{{ $req->message ?? '—' }}</td>
                <td>
                    @php
                        $badge = match($req->status) {
                            'pending'   => 'warning text-dark',
                            'fulfilled' => 'success',
                            'cancelled' => 'secondary',
                            default     => 'light',
                        };
                    @endphp
                    <span class="badge bg-{{ $badge }}">{{ ucfirst($req->status) }}</span>
                </td>
                <td>{{ $req->created_at->format('M d, Y') }}</td>
                <td>
                    @if ($req->status === 'pending')
                        <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#fulfillModal{{ $req->id }}">
                            Assign Trainer
                        </button>

                        {{-- Assign modal --}}
                        <div class="modal fade" id="fulfillModal{{ $req->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Assign Trainer — {{ $req->member->first_name }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST"
                                          action="/admin/trainer-requests/{{ $req->id }}/fulfill">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Trainer</label>
                                                <select name="trainer_id" class="form-select" required>
                                                    <option value="">-- Select Trainer --</option>
                                                    @foreach ($trainers as $trainer)
                                                        <option value="{{ $trainer->id }}">
                                                            {{ $trainer->full_name }}
                                                            @if ($trainer->specialty)
                                                                ({{ $trainer->specialty }})
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Assigned From</label>
                                                <input type="date" name="assigned_from"
                                                       class="form-control"
                                                       value="{{ now()->toDateString() }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Assigned To
                                                    <span class="text-muted small">(leave blank = ongoing)</span>
                                                </label>
                                                <input type="date" name="assigned_to" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Assign</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <span class="text-muted small">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">No trainer requests yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection