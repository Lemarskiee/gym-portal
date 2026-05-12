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

    <h1>Create Member</h1>

    <form action="/members" method="POST">
        @csrf

        <input type="text" name="first_name" placeholder="First Name" class="form-control">
        <br><br>

        <input type="text" name="last_name" placeholder="Last Name" class="form-control">
        <br><br>

        <input type="email" name="email" placeholder="Email" class="form-control">
        <br><br>

        <input type="text" name="phone" placeholder="Phone" class="form-control">
        <br><br>

        <input type="date" name="start_date" class="form-control">
        <br><br>

        <select name="membership_plan_id" class="form-control">
            @foreach($plans as $plan)
                <option value="{{ $plan->id }}">
                    {{ $plan->name }}
                </option>
            @endforeach
        </select>

        <br><br>

        <button type="submit" class="btn btn-success">Save Member</button>
    </form>

</div>

@endsection