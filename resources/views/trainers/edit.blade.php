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
    Edit Trainer
    </h2>

    <p class="text-center text-muted mb-4">
        Update coach profile information
    </p>

    <form action="/trainers/{{ $trainer->id }}" method="POST">
        @csrf
        @method('PUT')

        {{-- FULL NAME --}}
        <div class="mb-3">
            <input type="text"
                   name="full_name"
                   value="{{ $trainer->full_name }}"
                   class="form-control shadow-sm">
        </div>

        {{-- SPECIALTY --}}
        <div class="mb-3">
            <input type="text"
                   name="specialty"
                   value="{{ $trainer->specialty }}"
                   class="form-control shadow-sm">
        </div>

        {{-- PHONE --}}
        <div class="mb-4">
            <input type="text"
                   name="phone"
                   value="{{ $trainer->phone }}"
                   class="form-control shadow-sm">
        </div>

        {{-- BUTTON --}}
        <button type="submit"
                class="btn btn-warning w-100 fw-bold shadow-sm"
                style="border-radius: 10px;">
            Update Trainer
        </button>

    </form>

</div>

@endsection