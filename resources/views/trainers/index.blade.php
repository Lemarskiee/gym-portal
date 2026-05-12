@extends('layouts.app')

@section('content')

<div class="container-box">

    <h1>Trainers</h1>

    <a href="/trainers/create">Add Trainer</a>

    <hr>

    <table class="table table-bordered table-striped">
        <tr>
            <th>Name</th>
            <th>Specialty</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>

        @foreach($trainers as $trainer)
        <tr>
            <td>{{ $trainer->full_name }}</td>
            <td>{{ $trainer->specialty }}</td>
            <td>{{ $trainer->phone }}</td>

            <td>
                <a href="/trainers/{{ $trainer->id }}/edit">Edit</a>

                <form action="/trainers/{{ $trainer->id }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

</div>

@endsection