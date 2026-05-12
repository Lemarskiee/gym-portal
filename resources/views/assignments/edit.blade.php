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

    <h1>Edit Assignment</h1>

    <form action="/assignments/{{ $assignment->id }}" method="POST">
        @csrf
        @method('PUT')

        <label>Member</label>
        <br>

        <select name="member_id" class="form-control">
            @foreach($members as $member)
                <option value="{{ $member->id }}"
                    {{ $assignment->member_id == $member->id ? 'selected' : '' }}>
                    {{ $member->first_name }}
                    {{ $member->last_name }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label>Trainer</label>
        <br>

        <select name="trainer_id" class="form-control">
            @foreach($trainers as $trainer)
                <option value="{{ $trainer->id }}"
                    {{ $assignment->trainer_id == $trainer->id ? 'selected' : '' }}>
                    {{ $trainer->full_name }}
                </option>
            @endforeach
        </select>

        <br><br>

        <input type="date"
            name="assigned_from"
            value="{{ $assignment->assigned_from }}"
            class="form-control">

        <br><br>

        <input type="date"
            name="assigned_to"
            value="{{ $assignment->assigned_to }}"
            class="form-control">

        <br><br>

        <button type="submit" class="btn btn-warning">
            Update Assignment
        </button>
    </form>

</div>

@endsection