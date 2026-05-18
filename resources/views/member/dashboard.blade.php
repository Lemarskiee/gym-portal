@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">Welcome, {{ $member->first_name }}!</h4>

{{-- FLASH MESSAGES --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- TOP STATS --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-stat bg-primary text-white shadow-sm border-0" style="border-radius:14px;">
            <div class="card-body">
                <h6 class="opacity-75">Current Plan</h6>
                <h4 class="fw-bold mb-0">{{ $plan->name ?? 'N/A' }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat bg-success text-white shadow-sm border-0" style="border-radius:14px;">
            <div class="card-body">
                <h6 class="opacity-75">Trainer Assignments</h6>
                <h4 class="fw-bold mb-0">{{ $assignments->count() }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat bg-warning text-dark shadow-sm border-0" style="border-radius:14px;">
            <div class="card-body">
                <h6 class="opacity-75">Unpaid Bills</h6>
                <h4 class="fw-bold mb-0">{{ $billingLogs->where('status','unpaid')->count() }}</h4>
            </div>
        </div>
    </div>
</div>

{{-- BILLING HISTORY --}}
<div class="container-box mb-4 shadow-sm" style="border-radius:16px;">
    <h5 class="mb-3 fw-semibold">📄 My Billing History</h5>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Month</th>
                    <th>Amount Due</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Paid At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($billingLogs as $bill)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($bill->billing_month)->format('F Y') }}</td>
                    <td class="fw-semibold text-success">
                        ₱{{ number_format($bill->amount_due ?? 0, 2) }}
                    </td>
                    <td>{{ $bill->due_date ?? '—' }}</td>
                    <td>
                        <span class="badge px-3 py-2 bg-{{ $bill->status === 'paid' ? 'success' : 'danger' }}">
                            {{ ucfirst($bill->status) }}
                        </span>
                    </td>
                    <td>{{ $bill->paid_at ?? '—' }}</td>
                    <td>
                        @if ($bill->status === 'unpaid')
                            <form method="POST" action="/member/bills/{{ $bill->id }}/pay"
                                onsubmit="return confirm('Pay ₱{{ number_format($bill->amount_due, 2) }} for {{ \Carbon\Carbon::parse($bill->billing_month)->format('F Y') }}? This cannot be undone.')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    Pay Now
                                </button>
                            </form>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No billing records yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- TRAINER ASSIGNMENTS --}}
<div class="container-box mb-4 shadow-sm" style="border-radius:16px;">
    <h5 class="mb-3 fw-semibold">🏋️ My Trainer Assignments</h5>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Trainer</th>
                    <th>Specialty</th>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assignments as $a)
                <tr>
                    <td class="fw-semibold">{{ $a->trainer->full_name ?? '—' }}</td>
                    <td>{{ $a->trainer->specialty ?? 'General' }}</td>
                    <td>{{ $a->assigned_from ?? '—' }}</td>
                    <td>
                        <span class="badge bg-info text-dark px-3 py-2">
                            {{ $a->assigned_to ?? 'Ongoing' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">No trainer assigned yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- TRAINER REQUEST --}}
<div class="container-box shadow-sm" style="border-radius:16px;">
    <h5 class="mb-3 fw-semibold">📋 Request a Trainer</h5>

    @if ($hasPendingRequest)
        @php $pending = $trainerRequests->where('status','pending')->first(); @endphp
        <div class="alert alert-warning d-flex justify-content-between align-items-center mb-0">
            <div>
                <strong>Request pending review.</strong>
                @if ($pending->preferred_specialty)
                    Specialty: <em>{{ $pending->preferred_specialty }}</em> —
                @endif
                Submitted {{ $pending->created_at->diffForHumans() }}.
            </div>
            <form method="POST" action="/member/trainer-request/{{ $pending->id }}/cancel">
                @csrf
                <button class="btn btn-sm btn-outline-danger ms-3"
                        onclick="return confirm('Cancel your trainer request?')">
                    Cancel Request
                </button>
            </form>
        </div>
    @else
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/member/trainer-request">
            @csrf
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Preferred Specialty <span class="text-muted small">(optional)</span></label>
                    <input type="text" name="preferred_specialty" class="form-control"
                           placeholder="e.g. CrossFit, Yoga, Boxing"
                           value="{{ old('preferred_specialty') }}">
                </div>
                <div class="col-md-7">
                    <label class="form-label">Message <span class="text-muted small">(optional)</span></label>
                    <input type="text" name="message" class="form-control"
                           placeholder="Any notes for the admin..."
                           value="{{ old('message') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-dark mt-3">Submit Request</button>
        </form>
    @endif

    @if ($trainerRequests->isNotEmpty())
        <hr class="mt-4">
        <h6 class="text-muted mb-2">Request History</h6>
        <table class="table table-sm table-bordered mb-0">
            <thead class="table-secondary">
                <tr>
                    <th>Specialty</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainerRequests as $req)
                <tr>
                    <td>{{ $req->preferred_specialty ?? '—' }}</td>
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
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!--
{{-- PAY MODALS --}}
@foreach ($billingLogs as $bill)
    @if ($bill->status === 'unpaid')
    <div class="modal fade" id="payModal{{ $bill->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="z-index: 1056; position: relative;">
            <div class="modal-content border-0 shadow-lg"
                 style="background:#1e1e1e; color:#fff; border-radius:14px; position: relative; z-index: 1056;">

                <div class="modal-header border-0 pb-1">
                    <h5 class="modal-title fw-bold">Confirm Payment</h5>
                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <div class="modal-body pt-2">
                    <p class="text-white-50 mb-3">You are about to pay the following bill:</p>
                    <div class="rounded p-3 mb-3"
                         style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1);">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-white-50">Month</span>
                            <span class="fw-semibold">
                                {{ \Carbon\Carbon::parse($bill->billing_month)->format('F Y') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-white-50">Amount</span>
                            <span class="fw-bold text-success fs-5">
                                ₱{{ number_format($bill->amount_due, 2) }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-white-50">Due Date</span>
                            <span>{{ $bill->due_date }}</span>
                        </div>
                    </div>
                    <p class="text-white-50 small mb-0">
                        ⚠️ This action cannot be undone once confirmed.
                    </p>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <form method="POST" action="/member/bills/{{ $bill->id }}/pay">
                        @csrf
                        <button type="submit" class="btn btn-success px-4 fw-semibold">
                            ✅ Confirm Payment
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    @endif
@endforeach
!-->

@endsection