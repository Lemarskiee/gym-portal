@extends('layouts.app')

@section('content')

<div class="container-box">
        
    <h1>Billing Logs</h1>

    <a href="/billing/create">Add Billing</a>

    <hr>

    <table class="table table-bordered table-striped">
        <tr>
            <th>Member</th>
            <th>Billing Month</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Actions</th>
        </tr>

        @foreach($billings as $billing)
        <tr>
            <td>
                {{ $billing->member->first_name }}
                {{ $billing->member->last_name }}
            </td>

            <td>{{ $billing->billing_month }}</td>

            <td>{{ $billing->amount_due }}</td>

            <td>
                @if($billing->status == 'paid')
                    <span class="badge bg-success">Paid</span>
                @else
                    <span class="badge bg-danger">Unpaid</span>
                @endif
            </td>

            <td>{{ $billing->due_date }}</td>

            <td>
                <a href="/billing/{{ $billing->id }}/edit">
                    Edit
                </a>

                <form action="/billing/{{ $billing->id }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

</div>

@endsection