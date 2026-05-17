<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gym Portal') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* BACKGROUND IMAGE */
        .auth-bg {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;

            background: url('/images/gym-bg.jpeg') no-repeat center center fixed;
            background-size: cover;
        }

        /* DARK OVERLAY (matches login/register theme) */
        .auth-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.65);
            z-index: 0;
        }

        /* SUBTLE RED LIGHTS */
        .auth-bg::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(circle at 20% 30%, rgba(255, 40, 40, 0.15), transparent 45%),
                radial-gradient(circle at 80% 40%, rgba(255, 255, 255, 0.05), transparent 50%),
                radial-gradient(circle at 50% 80%, rgba(255, 0, 0, 0.10), transparent 55%);
            filter: blur(60px);
            animation: lightsMove 12s ease-in-out infinite alternate;
        }

        @keyframes lightsMove {
            0% { transform: translate(0px, 0px) scale(1); }
            50% { transform: translate(-20px, 10px) scale(1.05); }
            100% { transform: translate(20px, -10px) scale(1.02); }
        }

        /* GLASS AUTH CARD (STEEL STYLE) */
        .auth-card {
            position: relative;
            width: 100%;
            max-width: 440px;
            padding: 30px;
            border-radius: 16px;

            background: rgba(10, 10, 10, 0.75);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);

            border: 1px solid rgba(255, 0, 0, 0.15);
            box-shadow: 0 20px 60px rgba(0,0,0,0.8);

            z-index: 2;
            color: #fff;
        }

        /* subtle red edge glow */
        .auth-card::before {
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

        /* LOGO */
        .logo-wrapper {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo-wrapper a {
            display: inline-block;
            padding: 12px;
            border-radius: 50%;
            background: rgba(255, 0, 0, 0.08);
            box-shadow: 0 0 25px rgba(255, 0, 0, 0.15);
        }

        .logo-wrapper svg,
        .logo-wrapper img {
            filter: drop-shadow(0 0 8px #ff2e2e);
        }

        .app-title {
            text-align: center;
            margin-top: 10px;
            color: #ff2e2e;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* MAKE SLOT TEXT MATCH STYLE */
        .auth-card input,
        .auth-card select {
            background: rgba(0,0,0,0.6) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            color: #fff !important;
        }

        .auth-card label {
            color: rgba(255,255,255,0.75);
        }

        .auth-card input::placeholder {
            color: rgba(255,255,255,0.4);
        }

        /* BUTTON STYLE (GYM RED THEME) */
        .auth-card button,
        .auth-card .btn {
            background: #b30000 !important;
            border: none !important;
            color: #fff !important;
        }

        .auth-card button:hover,
        .auth-card .btn:hover {
            background: #ff1a1a !important;
        }

        /* CENTER FIX */
        .auth-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
    </style>
</head>

<body>

<div class="auth-bg">

    <div class="auth-wrapper">

        <div class="auth-card">

            <div class="logo-wrapper">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-300" />
                </a>

                <div class="app-title">
                    WEBFit
                </div>
            </div>

            {{ $slot }}

        </div>

    </div>

</div>

</body>
</html>