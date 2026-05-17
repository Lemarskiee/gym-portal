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
        Create Trainer
    </h2>

    <p class="text-center text-muted mb-4">
        Add a new fitness coach to the system
    </p>

    <form action="/trainers" method="POST">
        @csrf

        {{-- FULL NAME --}}
        <div class="mb-3">
            <input type="text"
                   name="full_name"
                   placeholder="Full Name"
                   class="form-control shadow-sm">
        </div>

        {{-- SPECIALTY --}}
        <div class="mb-3">
            <input type="text"
                   name="specialty"
                   placeholder="Specialty (e.g. CrossFit, Yoga)"
                   class="form-control shadow-sm">
        </div>

        {{-- PHONE --}}
        <div class="mb-4">
            <input type="text"
                   name="phone"
                   placeholder="Phone Number"
                   class="form-control shadow-sm">
        </div>

        {{-- BUTTON --}}
        <button type="submit"
                class="btn btn-success w-100 fw-bold shadow-sm"
                style="border-radius: 10px;">
            Save Trainer
        </button>

    </form>

</div>

@endsection