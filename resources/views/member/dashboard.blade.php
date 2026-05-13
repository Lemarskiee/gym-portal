@extends('layouts.app')

@section('content')
<h4 class="mb-4">Welcome, {{ $member->first_name }}!</h4>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-stat bg-primary text-white">
            <div class="card-body">
                <h6>Current Plan</h6>
                <h4>{{ $plan->name ?? 'N/A' }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat bg-success text-white">
            <div class="card-body">
                <h6>Trainer Assignments</h6>
                <h4>{{ $assignments->count() }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat bg-warning text-dark">
            <div class="card-body">
                <h6>Unpaid Bills</h6>
                <h4>{{ $billingLogs->where('status','unpaid')->count() }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="container-box mb-4">
    <h5 class="mb-3">My Billing History</h5>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Month</th><th>Amount Due</th><th>Due Date</th><th>Status</th><th>Paid At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($billingLogs as $bill)
            <tr>
                <td>{{ \Carbon\Carbon::parse($bill->billing_month)->format('F Y') }}</td>
                <td>₱{{ number_format($bill->amount_due, 2) }}</td>
                <td>{{ $bill->due_date }}</td>
                <td>
                    <span class="badge bg-{{ $bill->status === 'paid' ? 'success' : 'danger' }}">
                        {{ ucfirst($bill->status) }}
                    </span>
                </td>
                <td>{{ $bill->paid_at ?? '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">No billing records yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="container-box">
    <h5 class="mb-3">My Trainer Assignments</h5>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr><th>Trainer</th><th>Specialty</th><th>From</th><th>To</th></tr>
        </thead>
        <tbody>
            @forelse ($assignments as $a)
            <tr>
                <td>{{ $a->trainer->full_name }}</td>
                <td>{{ $a->trainer->specialty }}</td>
                <td>{{ $a->assigned_from }}</td>
                <td>{{ $a->assigned_to ?? 'Ongoing' }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">No trainer assigned yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection