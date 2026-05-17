<!DOCTYPE html>
<html>
<head>
    <title>Gym Membership Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: url('/images/gym-bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: #eaeaea;
            position: relative;
            min-height: 100vh;
        }

        /* DARK OVERLAY (same as login/register) */
        .bg-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.65);
            z-index: 0;
        }

        /* GLASS NAVBAR (matches login card style) */
        .navbar {
            background: rgba(10, 10, 10, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 0, 0, 0.15);
            z-index: 10;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
            color: #ff2e2e !important;
        }

        .nav-link {
            color: rgba(255,255,255,0.7) !important;
            transition: 0.2s;
        }

        .nav-link:hover {
            color: #ff2e2e !important;
            transform: translateY(-1px);
        }

        /* GLASS CONTAINERS (match login/register card) */
        .container-box {
            background: rgba(10, 10, 10, 0.75);
            border-radius: 16px;
            padding: 25px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 0, 0, 0.12);
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
        }

        /* TABLE DARK STYLE */
        table {
            background: rgba(20,20,20,0.8) !important;
            color: #eaeaea !important;
            border-radius: 12px;
            overflow: hidden;
        }

        table thead {
            background: rgba(0,0,0,0.9) !important;
        }

        /* BUTTON (match gym red theme) */
        .btn-success {
            background: #b30000 !important;
            border: none;
        }

        .btn-success:hover {
            background: #ff1a1a !important;
        }

        .btn-danger {
            background: #8b0000 !important;
            border: none;
        }

        .btn-warning {
            background: #ff3b3b !important;
            border: none;
            color: #fff !important;
        }

        /* page spacing fix */
        .container {
            padding-bottom: 40px;
            position: relative;
            z-index: 2;
        }

        /* fix navbar overlap click issues */
        nav {
            position: relative;
            z-index: 20;
        }
    </style>
</head>

<body>

<div class="bg-overlay"></div>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

        <a class="navbar-brand" href="/">
            WEBFit
        </a>

        <div class="d-flex align-items-center gap-3">

            @auth
                @if (auth()->user()->isAdmin())
                    <div class="navbar-nav flex-row gap-3">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                        <a class="nav-link" href="/plans">Plans</a>
                        <a class="nav-link" href="/members">Members</a>
                        <a class="nav-link" href="/trainers">Trainers</a>
                        <a class="nav-link" href="/assignments">Assignments</a>
                        <a class="nav-link" href="/billing">Billing</a>
                    </div>

                @elseif (auth()->user()->isMember())
                    <a class="nav-link" href="/member/dashboard">My Dashboard</a>

                @elseif (auth()->user()->isTrainer())
                    <a class="nav-link" href="/trainer/dashboard">My Dashboard</a>
                @endif

                <span class="text-white small opacity-75">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="/logout" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light">
                        Logout
                    </button>
                </form>

            @else
                <a class="nav-link" href="/login">Login</a>
                <a class="nav-link" href="/register">Register</a>
            @endauth

        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>