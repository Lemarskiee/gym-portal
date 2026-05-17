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
        Create New Member
    </h2>

    <p class="text-center text-muted mb-4">
        Add a new gym member and assign their membership plan
    </p>

    <form action="/members" method="POST">
        @csrf

        {{-- NAME --}}
        <div class="row g-2 mb-3">
            <div class="col-md-6">
                <input type="text"
                       name="first_name"
                       placeholder="First Name"
                       class="form-control shadow-sm">
            </div>

            <div class="col-md-6">
                <input type="text"
                       name="last_name"
                       placeholder="Last Name"
                       class="form-control shadow-sm">
            </div>
        </div>

        {{-- EMAIL --}}
        <div class="mb-3">
            <input type="email"
                   name="email"
                   placeholder="Email"
                   class="form-control shadow-sm">
        </div>

        {{-- PHONE --}}
        <div class="mb-3">
            <input type="text"
                   name="phone"
                   placeholder="Phone"
                   class="form-control shadow-sm">
        </div>

        {{-- START DATE --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Start Date</label>
            <input type="date"
                   name="start_date"
                   class="form-control shadow-sm">
        </div>

        {{-- PLAN --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Membership Plan</label>
            <select name="membership_plan_id"
                    class="form-select shadow-sm">

                @foreach($plans as $plan)
                    <option value="{{ $plan->id }}">
                        {{ $plan->name }}
                    </option>
                @endforeach

            </select>
        </div>

        {{-- BUTTON --}}
        <button type="submit"
                class="btn btn-success w-100 fw-bold shadow-sm"
                style="border-radius: 10px;">
            Save Member
        </button>

    </form>

</div>

@endsection