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

    <h1>Edit Billing</h1>

    <form action="/billing/{{ $billing->id }}" method="POST">
        @csrf
        @method('PUT')

        <select name="member_id" class="form-control">
            @foreach($members as $member)
                <option value="{{ $member->id }}"
                    {{ $billing->member_id == $member->id ? 'selected' : '' }}>
                    {{ $member->first_name }}
                    {{ $member->last_name }}
                </option>
            @endforeach
        </select>

        <br><br>

        <input type="date"
            name="billing_month"
            value="{{ $billing->billing_month }}"
            class="form-control">

        <br><br>

        <input type="number"
            step="0.01"
            name="amount_due"
            value="{{ $billing->amount_due }}"
            class="form-control">

        <br><br>

        <input type="date"
            name="due_date"
            value="{{ $billing->due_date }}"
            class="form-control">

        <br><br>

        <select name="status" class="form-control">
            <option value="paid"
                {{ $billing->status == 'paid' ? 'selected' : '' }}>
                Paid
            </option>

            <option value="unpaid"
                {{ $billing->status == 'unpaid' ? 'selected' : '' }}>
                Unpaid
            </option>
        </select>

        <br><br>

        <button type="submit" class="btn btn-warning">
            Update Billing
        </button>
    </form>

</div>

@endsection