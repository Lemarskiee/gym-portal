@extends('layouts.app')

@section('content')

<div class="container-box shadow-sm"
     style="border-radius: 16px;">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h2 class="fw-bold mb-0">Membership Plans</h2>
            <small class="text-muted">Manage all gym subscription plans</small>
        </div>

        <a href="/plans"
           class="btn btn-success fw-semibold"
           style="border-radius: 10px;">
            ➕ Add Plan
        </a>

    </div>

    <hr class="opacity-25">

    <div class="table-responsive">

        <table class="table table-bordered align-middle shadow-sm"
               style="border-radius: 12px; overflow: hidden;">

            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Duration</th>
                    <th>Price</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($plans as $plan)
                <tr>

                    <td class="fw-semibold">
                        {{ $plan->name }}
                    </td>

                    <td>
                        {{ $plan->duration_months }} months
                    </td>

                    <td class="text-success fw-bold">
                        ₱{{ number_format($plan->price, 2) }}
                    </td>

                    <td class="text-center">

                        <a href="/plans/{{ $plan->id }}/edit"
                           class="btn btn-sm btn-warning fw-semibold me-1"
                           style="border-radius: 8px;">
                            ✏️ Edit
                        </a>

                        <form action="/plans/{{ $plan->id }}"
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