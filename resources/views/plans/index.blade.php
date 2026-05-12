@extends('layouts.app')

@section('content')

<div class="container-box">

    <h1>Membership Plans</h1>

    <a href="/plans/create">Add Plan</a>

    <hr>

    <table class="table table-bordered table-striped">
        <tr>
            <th>Name</th>
            <th>Duration</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>

        @foreach($plans as $plan)
        <tr>
            <td>{{ $plan->name }}</td>
            <td>{{ $plan->duration_months }} months</td>
            <td>{{ $plan->price }}</td>

            <td>
                <a href="/plans/{{ $plan->id }}/edit">Edit</a>

                <form action="/plans/{{ $plan->id }}" method="POST">
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