@extends('layouts.app')

@section('content')

<div class="container-box shadow-sm"
     style="border-radius: 16px;">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h2 class="fw-bold mb-0">Billing Logs</h2>
            <small class="text-muted">Track member payments and dues</small>
        </div>

        <a href="/billing/create"
           class="btn btn-success fw-semibold"
           style="border-radius: 10px;">
            ➕ Add Billing
        </a>

    </div>

    <hr class="opacity-25">

    <div class="table-responsive">

        <table class="table table-bordered align-middle shadow-sm"
               style="border-radius: 12px; overflow: hidden;">

            <thead class="table-dark">
                <tr>
                    <th>Member</th>
                    <th>Billing Month</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($billings as $billing)
                <tr>

                    <td class="fw-semibold">
                        {{ $billing->member->first_name }}
                        {{ $billing->member->last_name }}
                    </td>

                    <td>
                        {{ $billing->billing_month }}
                    </td>

                    <td class="fw-bold text-success">
                        ₱{{ number_format($billing->amount_due, 2) }}
                    </td>

                    <td>
                        @if($billing->status == 'paid')
                            <span class="badge bg-success px-3 py-2">Paid</span>
                        @else
                            <span class="badge bg-danger px-3 py-2">Unpaid</span>
                        @endif
                    </td>

                    <td>
                        {{ $billing->due_date }}
                    </td>

                    <td class="text-center">

                        <a href="/billing/{{ $billing->id }}/edit"
                           class="btn btn-sm btn-warning fw-semibold me-1"
                           style="border-radius: 8px;">
                            ✏️ Edit
                        </a>

                        <form action="/billing/{{ $billing->id }}"
                              method="POST"
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-sm btn-danger fw-semibold"
                                    style="border-radius: 8px;">
                                🗑 Delete
                            </button>

                        </form>

                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection