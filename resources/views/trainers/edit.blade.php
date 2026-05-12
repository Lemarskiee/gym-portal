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

    <h1>Edit Trainer</h1>

    <form action="/trainers/{{ $trainer->id }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="full_name" value="{{ $trainer->full_name }}" class="form-control">
        <br><br>

        <input type="text" name="specialty" value="{{ $trainer->specialty }}" class="form-control">
        <br><br>

        <input type="text" name="phone" value="{{ $trainer->phone }}" class="form-control">
        <br><br>

        <button type="submit" class="btn btn-warning">Update Trainer</button>
    </form>

</div>

@endsection