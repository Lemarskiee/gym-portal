@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger shadow-sm">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-box shadow-sm"
     style="max-width: 650px; margin: auto; border-radius: 16px;">

    <h2 class="text-center fw-bold mb-2">
        Create Billing Log
    </h2>

    <p class="text-center text-muted mb-4">
        Assign payment records to gym members
    </p>

    <form action="/billing" method="POST">
        @csrf

        {{-- MEMBER --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Member</label>
            <select name="member_id"
                    class="form-select shadow-sm">

                @foreach($members as $member)
                    <option value="{{ $member->id }}">
                        {{ $member->first_name }} {{ $member->last_name }}
                    </option>
                @endforeach

            </select>
        </div>

        {{-- BILLING MONTH --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Billing Month</label>
            <input type="date"
                   name="billing_month"
                   class="form-control shadow-sm">
        </div>

        {{-- AMOUNT --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Amount Due</label>
            <input type="number"
                   step="0.01"
                   name="amount_due"
                   class="form-control shadow-sm"
                   placeholder="e.g. 1500.00">
        </div>

        {{-- DUE DATE --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Due Date</label>
            <input type="date"
                   name="due_date"
                   class="form-control shadow-sm">
        </div>

        {{-- STATUS --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Status</label>
            <select name="status"
                    class="form-select shadow-sm">

                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>

            </select>
        </div>

        {{-- BUTTON --}}
        <button type="submit"
                class="btn btn-success w-100 fw-bold shadow-sm"
                style="border-radius: 10px;">
            Save Billing
        </button>

    </form>

</div>

@endsection