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
        Assign Trainer
    </h2>

    <p class="text-center text-muted mb-4">
        Match members with trainers for personalized coaching
    </p>

    <form action="/assignments" method="POST">
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

        {{-- TRAINER --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Trainer</label>
            <select name="trainer_id"
                    class="form-select shadow-sm">

                @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}">
                        {{ $trainer->full_name }}
                    </option>
                @endforeach

            </select>
        </div>

        {{-- FROM DATE --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Assigned From</label>
            <input type="date"
                   name="assigned_from"
                   class="form-control shadow-sm">
        </div>

        {{-- TO DATE --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Assigned To</label>
            <input type="date"
                   name="assigned_to"
                   class="form-control shadow-sm">
        </div>

        {{-- BUTTON --}}
        <button type="submit"
                class="btn btn-success w-100 fw-bold shadow-sm"
                style="border-radius: 10px;">
            Save Assignment
        </button>

    </form>

</div>

@endsection