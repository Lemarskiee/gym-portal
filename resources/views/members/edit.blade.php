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

    <h1>Edit Member</h1>

    <form action="/members/{{ $member->id }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="first_name" value="{{ $member->first_name }}" class="form-control">
        <br><br>

        <input type="text" name="last_name" value="{{ $member->last_name }}" class="form-control">
        <br><br>

        <input type="email" name="email" value="{{ $member->email }}" class="form-control">
        <br><br>

        <input type="text" name="phone" value="{{ $member->phone }}" class="form-control">
        <br><br>

        <input type="date" name="start_date" value="{{ $member->start_date }}" class="form-control">
        <br><br>

        <select name="membership_plan_id" class="form-control">
            @foreach($plans as $plan)
                <option value="{{ $plan->id }}"
                    {{ $member->membership_plan_id == $plan->id ? 'selected' : '' }}>
                    {{ $plan->name }}
                </option>
            @endforeach
        </select>

        <br><br>

        <button type="submit" class="btn btn-warning">Update Member</button>
    </form>

</div>

@endsection