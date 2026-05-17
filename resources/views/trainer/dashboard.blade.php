@extends('layouts.app')

@section('content')

<h4 class="mb-4 fw-bold text-uppercase" style="letter-spacing: 1px;">
    🏋️ Welcome, {{ $trainer->full_name }}!
</h4>

{{-- STATS --}}
<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="card-stat text-white shadow-sm border-0"
             style="background: linear-gradient(135deg, #0dcaf0, #3dd5f3); border-radius: 12px;">
            <div class="p-3">
                <h6 class="opacity-75">Specialty</h6>
                <h4 class="fw-bold">{{ $trainer->specialty ?? 'N/A' }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-stat text-white shadow-sm border-0"
             style="background: linear-gradient(135deg, #212529, #343a40); border-radius: 12px;">
            <div class="p-3">
                <h6 class="opacity-75">Total Assigned Members</h6>
                <h4 class="fw-bold">{{ $assignments->count() }}</h4>
            </div>
        </div>
    </div>

</div>

{{-- TABLE --}}
<div class="container-box shadow-sm"
     style="border-radius: 16px;">

    <h5 class="mb-3 fw-bold">My Assigned Members</h5>

    <div class="table-responsive">

        <table class="table table-bordered align-middle"
               style="border-radius: 12px; overflow: hidden;">

            <thead class="table-dark">
                <tr>
                    <th>Member</th>
                    <th>Plan</th>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($assignments as $a)
                <tr>

                    <td class="fw-semibold">
                        {{ $a->member->first_name }} {{ $a->member->last_name }}
                    </td>

                    <td>
                        <span class="badge bg-primary px-3 py-2">
                            {{ $a->member->plan->name ?? 'N/A' }}
                        </span>
                    </td>

                    <td>
                        {{ $a->assigned_from }}
                    </td>

                    <td>
                        {{ $a->assigned_to ?? 'Ongoing' }}
                    </td>

                </tr>
                @empty

                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        No members assigned yet.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection