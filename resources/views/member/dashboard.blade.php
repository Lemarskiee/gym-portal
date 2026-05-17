@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold">
    Welcome, {{ $member->first_name }}!
</h4>

{{-- TOP STATS --}}
<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="card card-stat bg-primary text-white shadow-sm border-0"
             style="border-radius: 14px;">
            <div class="card-body">
                <h6 class="opacity-75">Current Plan</h6>
                <h4 class="fw-bold mb-0">{{ $plan->name ?? 'N/A' }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-stat bg-success text-white shadow-sm border-0"
             style="border-radius: 14px;">
            <div class="card-body">
                <h6 class="opacity-75">Trainer Assignments</h6>
                <h4 class="fw-bold mb-0">{{ $assignments->count() }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-stat bg-warning text-dark shadow-sm border-0"
             style="border-radius: 14px;">
            <div class="card-body">
                <h6 class="opacity-75">Unpaid Bills</h6>
                <h4 class="fw-bold mb-0">{{ $billingLogs->where('status','unpaid')->count() }}</h4>
            </div>
        </div>
    </div>

</div>

{{-- BILLING HISTORY --}}
<div class="container-box mb-4 shadow-sm"
     style="border-radius: 16px;">

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
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        No billing records yet.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

{{-- TRAINER ASSIGNMENTS --}}
<div class="container-box shadow-sm"
     style="border-radius: 16px;">

    <h5 class="mb-3 fw-semibold">My Trainer Assignments</h5>

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
                    <td class="fw-semibold">
                        {{ $a->trainer->full_name ?? '—' }}
                    </td>

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
                    <td colspan="4" class="text-center text-muted py-4">
                        No trainer assigned yet.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection