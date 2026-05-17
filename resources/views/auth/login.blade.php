@extends('layouts.app')

@section('content')

<style>
    body {
        background: url('/images/gym-bg.jpeg') no-repeat center center fixed;
        background-size: cover;
        overflow: hidden;
    }

    /* DARK OVERLAY */
    .login-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.65);
        z-index: 0;
    }

    /* SUBTLE GYM LIGHTS */
    .gym-lights {
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background:
            radial-gradient(circle at 20% 30%, rgba(255, 40, 40, 0.15), transparent 45%),
            radial-gradient(circle at 80% 40%, rgba(255, 255, 255, 0.06), transparent 50%),
            radial-gradient(circle at 50% 80%, rgba(255, 0, 0, 0.10), transparent 55%);
        animation: moveLights 14s infinite alternate ease-in-out;
        filter: blur(70px);
    }

    @keyframes moveLights {
        0% { transform: translate(0px, 0px) scale(1); }
        50% { transform: translate(-25px, 15px) scale(1.05); }
        100% { transform: translate(25px, -15px) scale(1.02); }
    }

    /* FLOATING ICONS */
    .float-icon {
        position: fixed;
        font-size: 22px;
        opacity: 0.08;
        animation: floatUp 16s infinite linear;
        z-index: 0;
        pointer-events: none;
        filter: grayscale(100%);
    }

    @keyframes floatUp {
        0% { transform: translateY(100vh) rotate(0deg); }
        100% { transform: translateY(-10vh) rotate(360deg); }
    }

    /* GLASS CARD */
    .glass-card {
        position: relative;
        background: rgba(10, 10, 10, 0.75);
        border-radius: 16px;
        color: #fff;
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.8);
        overflow: hidden;
        z-index: 2;
        border: 1px solid rgba(255, 0, 0, 0.15);
    }

    .glass-card::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 16px;
        padding: 1px;
        background: linear-gradient(135deg, rgba(255,0,0,0.4), transparent, rgba(255,0,0,0.2));
        -webkit-mask:
            linear-gradient(#fff 0 0) content-box,
            linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
    }

    /* INPUT */
    .glass-card input {
        background: rgba(0,0,0,0.6) !important;
        border: 1px solid rgba(255,255,255,0.1);
        color: #fff !important;
    }

    .glass-card input:focus {
        border-color: #ff2e2e;
        box-shadow: 0 0 0 0.15rem rgba(255, 46, 46, 0.25);
    }

    .glass-card label {
        color: rgba(255,255,255,0.75);
    }

    /* BUTTON */
    .btn-success {
        background: #b30000 !important;
        border: none;
    }

    .btn-success:hover {
        background: #ff1a1a !important;
    }

    /* ========================= */
    /* GYM SCAN AUTHENTICATOR */
    /* ========================= */

    .gym-scan {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .hidden {
        display: none;
    }

    .scan-box {
        text-align: center;
        color: #fff;
    }

    .scan-line {
        width: 240px;
        height: 4px;
        background: #ff1a1a;
        margin: 0 auto 25px;
        box-shadow: 0 0 20px #ff1a1a;
        animation: scanMove 1.2s infinite alternate ease-in-out;
    }

    @keyframes scanMove {
        0% { transform: translateY(0px); opacity: 0.5; }
        100% { transform: translateY(120px); opacity: 1; }
    }

    .scan-text {
        font-weight: 800;
        letter-spacing: 2px;
        color: #ff1a1a;
        animation: pulse 1s infinite;
    }

    @keyframes pulse {
        0% { opacity: 0.4; }
        50% { opacity: 1; }
        100% { opacity: 0.4; }
    }

    .scan-sub {
        font-size: 14px;
        opacity: 0.6;
        margin-top: 10px;
    }
</style>

{{-- OVERLAYS --}}
<div class="login-overlay"></div>
<div class="gym-lights"></div>

{{-- FLOATING ICONS --}}
<div class="float-icon" style="left:10%">❚█══█❚</div>
<div class="float-icon" style="left:25%; animation-delay:2s;">⩇⩇:⩇⩇</div>
<div class="float-icon" style="left:55%; animation-delay:4s;">˗ˏˋ ✞ ˎˊ˗
      ❚█══█❚
     </div>
<div class="float-icon" style="left:75%; animation-delay:1s;">⩇⩇:⩇⩇</div>

{{-- GYM SCAN OVERLAY --}}
<div id="gymScan" class="gym-scan hidden">
    <div class="scan-box">
        <div class="scan-line"></div>
        <h2 id="scanText" class="scan-text">SCANNING...</h2>
        <p class="scan-sub">Verifying credentials</p>
    </div>
</div>

{{-- LOGIN CONTENT --}}
<div class="row justify-content-center" style="position: relative; z-index: 2;">

    <div class="col-md-5">

        <div class="glass-card">

            <div class="text-center p-4 border-bottom border-light border-opacity-10">

                <h3 class="fw-bold mb-1">
                    WEBFit
                </h3>

                <p class="mb-0 text-white-50">
                    Enter your account to continue training
                </p>

            </div>

            <div class="p-4">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form id="loginForm" method="POST" action="/login">
                    @csrf

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold" style="border-radius: 10px;">
                        🔐 Login
                    </button>

                </form>

                <hr class="border-light border-opacity-10">

                <p class="text-center mb-0">
                    No account?
                    <a href="/register" class="fw-bold text-danger">Register here</a>
                </p>

            </div>

        </div>

    </div>

</div>

{{-- GYM SCAN SCRIPT --}}
<script>
    const form = document.getElementById("loginForm");
    const scan = document.getElementById("gymScan");
    const scanText = document.getElementById("scanText");

    if (form) {
        form.addEventListener("submit", function(e) {
            e.preventDefault();

            scan.classList.remove("hidden");

            const messages = [
                "SCANNING...",
                "CHECKING SYSTEM...",
                "VERIFYING DATA...",
                "AUTHENTICATING...",
                "WELCOME, ATHLETE"
            ];

            let i = 0;

            const interval = setInterval(() => {
                scanText.textContent = messages[i];
                i++;

                if (i >= messages.length) {
                    clearInterval(interval);

                    setTimeout(() => {
                        form.submit();
                    }, 600);
                }
            }, 700);
        });
    }
</script>

@endsection