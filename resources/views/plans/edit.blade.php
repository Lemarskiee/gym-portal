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
     style="max-width: 600px; margin: auto; border-radius: 16px;">

    <h2 class="text-center fw-bold mb-2">
        Edit Membership Plan
    </h2>

    <p class="text-center text-muted mb-4">
        Update plan details to keep your gym system optimized
    </p>

    <form action="/plans/{{ $plan->id }}" method="POST">
        @csrf
        @method('PUT')

        {{-- PLAN NAME --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Plan Name</label>
            <input type="text"
                   name="name"
                   value="{{ $plan->name }}"
                   class="form-control shadow-sm">
        </div>

        {{-- DURATION --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Duration (Months)</label>
            <input type="number"
                   name="duration_months"
                   value="{{ $plan->duration_months }}"
                   class="form-control shadow-sm">
        </div>

        {{-- PRICE --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Price</label>
            <input type="number"
                   step="0.01"
                   name="price"
                   value="{{ $plan->price }}"
                   class="form-control shadow-sm">
        </div>

        {{-- BUTTON --}}
        <button type="submit"
                class="btn btn-warning w-100 fw-bold shadow-sm"
                style="border-radius: 10px;">
            Update Plan
        </button>

    </form>

</div>

@endsection