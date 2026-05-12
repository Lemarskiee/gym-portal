@extends('layouts.app')

@section('content')

<div class="container-box">

    <h1>Members</h1>

    <a href="/members/create">Add Member</a>

    <hr>

    <table class="table table-bordered table-striped">
        <tr>
            <th>Name</th>
            <th>Plan</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>

        @foreach($members as $member)
        <tr>
            <td>{{ $member->first_name }} {{ $member->last_name }}</td>
            <td>{{ $member->plan->name }}</td>
            <td>{{ $member->email }}</td>
            <td>{{ $member->phone }}</td>

            <td>
                <a href="/members/{{ $member->id }}/edit">Edit</a>

                <form action="/members/{{ $member->id }}" method="POST">
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