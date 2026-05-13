<!DOCTYPE html>
<html>
<head>
    <title>Gym Membership Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f6fa; }
        .navbar { margin-bottom: 30px; }
        .card-stat {
            border: none;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        table { background: white; }
        .container-box {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Gym Portal</a>

        <div class="d-flex align-items-center gap-3">

            @auth
                @if (auth()->user()->isAdmin())
                    <div class="navbar-nav flex-row gap-2">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                        <a class="nav-link" href="/plans">Plans</a>
                        <a class="nav-link" href="/members">Members</a>
                        <a class="nav-link" href="/trainers">Trainers</a>
                        <a class="nav-link" href="/assignments">Assignments</a>
                        <a class="nav-link" href="/billing">Billing</a>
                    </div>
                @elseif (auth()->user()->isMember())
                    <div class="navbar-nav flex-row gap-2">
                        <a class="nav-link" href="/member/dashboard">My Dashboard</a>
                    </div>
                @elseif (auth()->user()->isTrainer())
                    <div class="navbar-nav flex-row gap-2">
                        <a class="nav-link" href="/trainer/dashboard">My Dashboard</a>
                    </div>
                @endif

                <span class="text-white small">{{ auth()->user()->name }}</span>

                <form method="POST" action="/logout" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            @else
                <a class="nav-link text-white" href="/login">Login</a>
                <a class="nav-link text-white" href="/register">Register</a>
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