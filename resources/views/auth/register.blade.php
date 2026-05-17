@extends('layouts.app')

@section('content')

<style>
    body {
        background: url('/images/gym-bg.jpeg') no-repeat center center fixed;
        background-size: cover;
        overflow-x: hidden;
    }

    /* STRONG DARK OVERLAY */
    .login-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.72);
        z-index: 0;
    }

    /* INDUSTRIAL LIGHT EFFECTS (no neon/rainbow) */
    .gym-lights {
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background:
            radial-gradient(circle at 20% 25%, rgba(255, 30, 30, 0.10), transparent 45%),
            radial-gradient(circle at 80% 40%, rgba(255,255,255,0.04), transparent 50%),
            radial-gradient(circle at 50% 80%, rgba(255, 0, 0, 0.08), transparent 55%);
        animation: moveLights 14s infinite alternate ease-in-out;
        filter: blur(70px);
    }

    @keyframes moveLights {
        0% { transform: translate(0px, 0px) scale(1); }
        50% { transform: translate(-20px, 15px) scale(1.04); }
        100% { transform: translate(20px, -15px) scale(1.02); }
    }

    /* FLOATING ICONS (very subtle) */
    .float-icon {
        position: fixed;
        font-size: 22px;
        opacity: 0.07;
        animation: floatUp 18s linear infinite;
        z-index: 0;
        pointer-events: none;
        filter: grayscale(100%);
    }

    @keyframes floatUp {
        0% { transform: translateY(100vh) rotate(0deg); }
        100% { transform: translateY(-10vh) rotate(360deg); }
    }

    /* GLASS CARD (STEEL / TOUGH LOOK) */
    .glass-card {
        position: relative;
        background: rgba(10, 10, 10, 0.80);
        border-radius: 16px;
        color: #fff;
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 25px 70px rgba(0,0,0,0.85);
        overflow: hidden;
        z-index: 2;
        border: 1px solid rgba(255, 0, 0, 0.15);
    }

    /* subtle red edge glow */
    .glass-card::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 16px;
        padding: 1px;
        background: linear-gradient(
            135deg,
            rgba(255,0,0,0.35),
            transparent,
            rgba(255,0,0,0.12)
        );
        -webkit-mask:
            linear-gradient(#fff 0 0) content-box,
            linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
    }

    /* INPUT STYLE */
    .glass-card input,
    .glass-card select {
        background: rgba(0,0,0,0.65) !important;
        border: 1px solid rgba(255,255,255,0.10);
        color: #fff !important;
    }

    .glass-card input:focus,
    .glass-card select:focus {
        border-color: #ff2e2e;
        box-shadow: 0 0 0 0.15rem rgba(255, 46, 46, 0.25);
    }

    .glass-card input::placeholder {
        color: rgba(255,255,255,0.35);
    }

    .glass-card label {
        color: rgba(255,255,255,0.75);
    }

    /* BUTTON (RED = STRONG GYM THEME) */
    .btn-success {
        background: #b30000 !important;
        border: none;
    }

    .btn-success:hover {
        background: #ff1a1a !important;
    }

    /* SUB SECTIONS */
    #memberFields,
    #trainerFields {
        border: 1px solid rgba(255,255,255,0.08);
    }
</style>

{{-- BACKGROUND --}}
<div class="login-overlay"></div>
<div class="gym-lights"></div>

{{-- FLOAT ICONS --}}
<div class="float-icon" style="left:10%">💪</div>
<div class="float-icon" style="left:25%; animation-delay:2s;">🏋️</div>
<div class="float-icon" style="left:55%; animation-delay:4s;">💪</div>
<div class="float-icon" style="left:75%; animation-delay:1s;">🏋️</div>

{{-- CONTENT --}}
<div class="row justify-content-center" style="position: relative; z-index: 2;">

    <div class="col-md-7">

        <div class="glass-card">

            {{-- HEADER --}}
            <div class="text-center p-4 border-bottom border-light border-opacity-10">

                <h3 class="fw-bold mb-1">
                    Create Your WEBFit Account
                </h3>

                <p class="mb-0 text-white-50">
                    Build strength. Track progress. No excuses.
                </p>

            </div>

            <div class="p-4">

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
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Register as</label>
                        <select name="role" id="roleSelect" class="form-select" required>
                            <option value="">-- Select Role --</option>
                            <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>
                                Member
                            </option>
                            <option value="trainer" {{ old('role') === 'trainer' ? 'selected' : '' }}>
                                Trainer
                            </option>
                        </select>
                    </div>

                    {{-- MEMBER --}}
                    <div id="memberFields" class="p-3 mb-3 rounded"
                         style="display:none; background: rgba(0,0,0,0.55);">

                        <h6 class="mb-3 fw-bold">💳 Membership Details</h6>

                        <select name="membership_plan_id" class="form-select mb-3">
                            <option value="">-- Select Plan --</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}">
                                    {{ $plan->name }} ({{ $plan->duration_months }} mo — ₱{{ number_format($plan->price, 2) }})
                                </option>
                            @endforeach
                        </select>

                        <input type="date" name="start_date" class="form-control">

                    </div>

                    {{-- TRAINER --}}
                    <div id="trainerFields" class="p-3 mb-3 rounded"
                         style="display:none; background: rgba(0,0,0,0.55);">

                        <h6 class="mb-3 fw-bold">Trainer Profile</h6>

                        <input type="text" name="specialty" class="form-control" placeholder="e.g. CrossFit, Yoga">

                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold" style="border-radius: 12px;">
                        Create Account
                    </button>

                </form>

                <hr class="border-light border-opacity-10">

                <p class="text-center mb-0">
                    Already have an account?
                    <a href="/login" class="fw-bold text-danger">Login here</a>
                </p>

            </div>

        </div>

    </div>

</div>

<script>
    const roleSelect = document.getElementById('roleSelect');
    const memberFields = document.getElementById('memberFields');
    const trainerFields = document.getElementById('trainerFields');

    function toggleFields() {
        memberFields.style.display = roleSelect.value === 'member' ? 'block' : 'none';
        trainerFields.style.display = roleSelect.value === 'trainer' ? 'block' : 'none';
    }

    roleSelect.addEventListener('change', toggleFields);
    toggleFields();
</script>

@endsection