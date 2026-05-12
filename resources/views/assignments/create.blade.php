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

    <h1>Assign Trainer</h1>

    <form action="/assignments" method="POST">
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

        <label>Trainer</label>
        <br>

        <select name="trainer_id" class="form-control">
            @foreach($trainers as $trainer)
                <option value="{{ $trainer->id }}">
                    {{ $trainer->full_name }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label>Assigned From</label>
        <br>

        <input type="date" name="assigned_from" class="form-control">

        <br><br>

        <label>Assigned To</label>
        <br>

        <input type="date" name="assigned_to" class="form-control">

        <br><br>

        <button type="submit" class="btn btn-success">
            Save Assignment
        </button>
    </form>

</div>

@endsection