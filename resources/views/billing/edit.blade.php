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
        Edit Billing
    </h2>

    <p class="text-center text-muted mb-4">
        Update member billing details and payment status
    </p>

    <form action="/billing/{{ $billing->id }}" method="POST">
        @csrf
        @method('PUT')

        {{-- MEMBER --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Member</label>
            <select name="member_id"
                    class="form-select shadow-sm">

                @foreach($members as $member)
                    <option value="{{ $member->id }}"
                        {{ $billing->member_id == $member->id ? 'selected' : '' }}>
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
                   value="{{ $billing->billing_month }}"
                   class="form-control shadow-sm">
        </div>

        {{-- AMOUNT --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Amount Due</label>
            <input type="number"
                   step="0.01"
                   name="amount_due"
                   value="{{ $billing->amount_due }}"
                   class="form-control shadow-sm">
        </div>

        {{-- DUE DATE --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Due Date</label>
            <input type="date"
                   name="due_date"
                   value="{{ $billing->due_date }}"
                   class="form-control shadow-sm">
        </div>

        {{-- STATUS --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Status</label>
            <select name="status"
                    class="form-select shadow-sm">

                <option value="paid"
                    {{ $billing->status == 'paid' ? 'selected' : '' }}>
                    Paid
                </option>

                <option value="unpaid"
                    {{ $billing->status == 'unpaid' ? 'selected' : '' }}>
                    Unpaid
                </option>

            </select>
        </div>

        {{-- BUTTON --}}
        <button type="submit"
                class="btn btn-warning w-100 fw-bold shadow-sm"
                style="border-radius: 10px;">
            Update Billing
        </button>

    </form>

</div>

@endsection