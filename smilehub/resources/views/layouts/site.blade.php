<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmileHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2 py-2">

        <a class="navbar-brand fw-bold m-0" href="{{ route('home') }}">SmileHub</a>

        <!-- Links -->
        <ul class="navbar-nav flex-row flex-wrap gap-3">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('home') ? 'fw-bold text-decoration-underline' : '' }}"
                   href="{{ route('home') }}">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('services') ? 'fw-bold text-decoration-underline' : '' }}"
                   href="{{ route('services') }}">Services</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('about') ? 'fw-bold text-decoration-underline' : '' }}"
                   href="{{ route('about') }}">About</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('contact') ? 'fw-bold text-decoration-underline' : '' }}"
                   href="{{ route('contact') }}">Contact</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('appointments.create') ? 'fw-bold text-decoration-underline' : '' }}"
                   href="{{ route('appointments.create') }}">Book</a>
            </li>
        </ul>

        <!-- Auth -->
        <ul class="navbar-nav flex-row flex-wrap gap-2 align-items-center">
            @auth
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('appointments.my') ? 'fw-bold text-decoration-underline' : '' }}"
                       href="{{ route('appointments.my') }}">My Appointments</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'fw-bold text-decoration-underline' : '' }}"
                       href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('login') ? 'fw-bold text-decoration-underline' : '' }}"
                       href="{{ route('login') }}">Login</a>
                </li>

                <li class="nav-item">
                    <a class="btn btn-light btn-sm {{ request()->routeIs('register') ? 'fw-bold' : '' }}"
                       href="{{ route('register') }}">Register</a>
                </li>
            @endauth
        </ul>

    </div>
</nav>

<main class="py-4">
    @yield('content')
</main>

<footer class="py-4 mt-5 bg-white border-top">
    <div class="container text-center text-muted">
        © {{ date('Y') }} SmileHub - Dental Clinic
    </div>
</footer>

</body>
</html>
