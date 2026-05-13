@extends('layouts.app')

@section('content')
<h4 class="mb-4">Welcome, {{ $trainer->full_name }}!</h4>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-stat bg-info text-white">
            <div class="card-body">
                <h6>Specialty</h6>
                <h4>{{ $trainer->specialty ?? 'N/A' }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat bg-dark text-white">
            <div class="card-body">
                <h6>Total Assigned Members</h6>
                <h4>{{ $assignments->count() }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="container-box">
    <h5 class="mb-3">My Assigned Members</h5>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr><th>Member</th><th>Plan</th><th>From</th><th>To</th></tr>
        </thead>
        <tbody>
            @forelse ($assignments as $a)
            <tr>
                <td>{{ $a->member->first_name }} {{ $a->member->last_name }}</td>
                <td>{{ $a->member->plan->name ?? 'N/A' }}</td>
                <td>{{ $a->assigned_from }}</td>
                <td>{{ $a->assigned_to ?? 'Ongoing' }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">No members assigned yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection