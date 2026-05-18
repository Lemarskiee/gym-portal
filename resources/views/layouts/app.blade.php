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

        /* FIX: negative z-index so it never blocks modals or any interactive element */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.65);
            z-index: 0;
            pointer-events: none;
        }

        .navbar {
            background: rgba(10, 10, 10, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 0, 0, 0.15);
            z-index: 1030;
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

        /* Let Bootstrap's own CSS variables control modal layering */
        :root {
            --bs-modal-zindex: 9999;
            --bs-backdrop-zindex: 9998;
        }

        /* Remove backdrop-filter from container-box — it creates a stacking context that traps modals */
        .container-box {
            background: rgba(10, 10, 10, 0.85);
            border-radius: 16px;
            padding: 25px;
            border: 1px solid rgba(255, 0, 0, 0.12);
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
        }

        table {
            background: rgba(20,20,20,0.8) !important;
            color: #eaeaea !important;
            border-radius: 12px;
            overflow: hidden;
        }

        table thead {
            background: rgba(0,0,0,0.9) !important;
        }

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

        .container {
            padding-bottom: 40px;
            position: relative;
            z-index: 2;
        }

        nav {
            position: relative;
            z-index: 1030;
        }

        .modal-dialog {
            position: relative;
            z-index: 1056;
        }
        .modal.show {
            display: block !important;
            z-index: 1055;
        }
        .modal-backdrop.show {
            z-index: 1054;
        }

    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

        <a class="navbar-brand" href="/">WEBFit</a>

        <div class="d-flex align-items-center gap-3">
            @auth
                @if (auth()->user()->isAdmin())
                    <div class="navbar-nav flex-row gap-3">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                        <a class="nav-link" href="/plans">Plans</a>
                        <a class="nav-link" href="/members">Members</a>
                        <a class="nav-link" href="/trainers">Trainers</a>
                        <a class="nav-link" href="/admin/trainer-requests">Trainer Requests</a>
                        <a class="nav-link" href="/assignments">Assignments</a>
                        <a class="nav-link" href="/billing">Billing</a>
                        <a class="nav-link" href="/admin/applications">Applications</a>
                    </div>
                @elseif (auth()->user()->isMember())
                    <a class="nav-link" href="/member/dashboard">My Dashboard</a>
                @elseif (auth()->user()->isTrainer())
                    <a class="nav-link" href="/trainer/dashboard">My Dashboard</a>
                @endif

                <span class="text-white small opacity-75">{{ auth()->user()->name }}</span>

                <form method="POST" action="/logout" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
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