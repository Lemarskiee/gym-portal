@extends('layouts.app')

@section('content')

<div class="container-box">

    <h1>Trainer Assignments</h1>

    <a href="/assignments/create">Assign Trainer</a>

    <hr>

    <table class="table table-bordered table-striped">
        <tr>
            <th>Member</th>
            <th>Trainer</th>
            <th>From</th>
            <th>To</th>
            <th>Actions</th>
        </tr>

        @foreach($assignments as $assignment)
        <tr>
            <td>
                {{ $assignment->member->first_name }}
                {{ $assignment->member->last_name }}
            </td>

            <td>
                {{ $assignment->trainer->full_name }}
            </td>

            <td>{{ $assignment->assigned_from }}</td>

            <td>{{ $assignment->assigned_to }}</td>

            <td>
                <a href="/assignments/{{ $assignment->id }}/edit">
                    Edit
                </a>

                <form action="/assignments/{{ $assignment->id }}" method="POST">
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