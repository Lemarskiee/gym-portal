@extends('layouts.app')

@section('content')

<div class="container-box shadow-sm"
     style="border-radius: 16px;">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h2 class="fw-bold mb-0">Trainer Assignments</h2>
            <small class="text-muted">Manage member–trainer relationships</small>
        </div>

        <a href="/assignments/create"
           class="btn btn-success fw-semibold"
           style="border-radius: 10px;">
            ➕ Assign Trainer
        </a>

    </div>

    <hr class="opacity-25">

    <div class="table-responsive">

        <table class="table table-bordered align-middle shadow-sm"
               style="border-radius: 12px; overflow: hidden;">

            <thead class="table-dark">
                <tr>
                    <th>Member</th>
                    <th>Trainer</th>
                    <th>From</th>
                    <th>To</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($assignments as $assignment)
                <tr>

                    <td class="fw-semibold">
                        {{ $assignment->member->first_name }}
                        {{ $assignment->member->last_name }}
                    </td>

                    <td>
                        <span class="badge bg-primary px-3 py-2">
                            {{ $assignment->trainer->full_name }}
                        </span>
                    </td>

                    <td>
                        {{ $assignment->assigned_from }}
                    </td>

                    <td>
                        {{ $assignment->assigned_to ?? 'Ongoing' }}
                    </td>

                    <td class="text-center">

                        <a href="/assignments/{{ $assignment->id }}/edit"
                           class="btn btn-sm btn-warning fw-semibold me-1"
                           style="border-radius: 8px;">
                            ✏️ Edit
                        </a>

                        <form action="/assignments/{{ $assignment->id }}"
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