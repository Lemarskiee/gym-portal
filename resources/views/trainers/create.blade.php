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

    <h1>Create Trainer</h1>

    <form action="/trainers" method="POST">
        @csrf

        <input type="text" name="full_name" placeholder="Full Name" class="form-control">
        <br><br>

        <input type="text" name="specialty" placeholder="Specialty" class="form-control">
        <br><br>

        <input type="text" name="phone" placeholder="Phone" class="form-control">
        <br><br>

        <button type="submit" class="btn btn-success">Save Trainer</button>
    </form>

</div>

@endsection