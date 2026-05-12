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

    <h1>Edit Membership Plan</h1>

    <form action="/plans/{{ $plan->id }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Plan Name</label>
            <input type="text" name="name" value="{{ $plan->name }}" class="form-control">
        </div>

        <br>

        <div>
            <label>Duration (Months)</label>
            <input type="number" name="duration_months" value="{{ $plan->duration_months }}" class="form-control">
        </div>

        <br>

        <div>
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="{{ $plan->price }}" class="form-control">
        </div>

        <br>

        <button type="submit" class="btn btn-warning">
            Update Plan
        </button>
    </form>

</div>    

@endsection