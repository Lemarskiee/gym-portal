@extends('layouts.app')

@section('content')

<div class="container-box shadow-sm"
     style="border-radius: 16px;">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h2 class="fw-bold mb-0">Trainers</h2>
            <small class="text-muted">Manage all gym coaches</small>
        </div>

        <a href="/trainers/create"
           class="btn btn-success fw-semibold"
           style="border-radius: 10px;">
            ➕ Add Trainer
        </a>

    </div>

    <hr class="opacity-25">

    <div class="table-responsive">

        <table class="table table-bordered align-middle shadow-sm"
               style="border-radius: 12px; overflow: hidden;">

            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Specialty</th>
                    <th>Phone</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($trainers as $trainer)
                <tr>

                    <td class="fw-semibold">
                        {{ $trainer->full_name }}
                    </td>

                    <td>
                        <span class="badge bg-info text-dark px-3 py-2">
                            {{ $trainer->specialty }}
                        </span>
                    </td>

                    <td>
                        {{ $trainer->phone }}
                    </td>

                    <td class="text-center">

                        <a href="/trainers/{{ $trainer->id }}/edit"
                           class="btn btn-sm btn-warning fw-semibold me-1"
                           style="border-radius: 8px;">
                            ✏️ Edit
                        </a>

                        <form action="/trainers/{{ $trainer->id }}"
                              method="POST"
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-sm btn-danger fw-semibold"
                                    style="border-radius: 8px;">
                                🗑 Delete
                            </button>

                        </form>

                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection