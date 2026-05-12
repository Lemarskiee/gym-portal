@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-box">

    <h1>Create Billing Log</h1>

    <form action="/billing" method="POST">
        @csrf

        <label>Member</label>
        <br>

        <select name="member_id" class="form-control">
            @foreach($members as $member)
                <option value="{{ $member->id }}">
                    {{ $member->first_name }}
                    {{ $member->last_name }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label>Billing Month</label>
        <br>

        <input type="date" name="billing_month" class="form-control">

        <br><br>

        <label>Amount Due</label>
        <br>

        <input type="number" step="0.01" name="amount_due" class="form-control">

        <br><br>

        <label>Due Date</label>
        <br>

        <input type="date" name="due_date" class="form-control">

        <br><br>

        <label>Status</label>
        <br>

        <select name="status" class="form-control">
            <option value="paid">Paid</option>
            <option value="unpaid">Unpaid</option>
        </select>

        <br><br>

        <button type="submit" class="btn btn-success">
            Save Billing
        </button>
    </form>

</div>

@endsection