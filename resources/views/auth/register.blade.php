@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="container-box">
            <h4 class="mb-4">Register</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Register as</label>
                    <select name="role" id="roleSelect" class="form-select" required>
                        <option value="">-- Select Role --</option>
                        <option value="member"  {{ old('role') === 'member'  ? 'selected' : '' }}>Member</option>
                        <option value="trainer" {{ old('role') === 'trainer' ? 'selected' : '' }}>Trainer</option>
                    </select>
                </div>

                {{-- Member-only fields --}}
                <div id="memberFields" style="display:none;">
                    <div class="mb-3">
                        <label class="form-label">Membership Plan</label>
                        <select name="membership_plan_id" class="form-select">
                            <option value="">-- Select Plan --</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" {{ old('membership_plan_id') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }} ({{ $plan->duration_months }} mo — ₱{{ number_format($plan->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                    </div>
                </div>

                {{-- Trainer-only fields --}}
                <div id="trainerFields" style="display:none;">
                    <div class="mb-3">
                        <label class="form-label">Specialty</label>
                        <input type="text" name="specialty" class="form-control" value="{{ old('specialty') }}" placeholder="e.g. CrossFit, Yoga">
                    </div>
                </div>

                <button type="submit" class="btn btn-dark w-100">Register</button>
            </form>

            <hr>
            <p class="text-center mb-0">Already have an account? <a href="/login">Login here</a></p>
        </div>
    </div>
</div>

<script>
    const roleSelect = document.getElementById('roleSelect');
    const memberFields = document.getElementById('memberFields');
    const trainerFields = document.getElementById('trainerFields');

    function toggleFields() {
        memberFields.style.display  = roleSelect.value === 'member'  ? 'block' : 'none';
        trainerFields.style.display = roleSelect.value === 'trainer' ? 'block' : 'none';
    }

    roleSelect.addEventListener('change', toggleFields);
    toggleFields(); // run on load for old() repopulation
</script>
@endsection