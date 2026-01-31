<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name')) — Digital Lands</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .guest-bg {
            background: linear-gradient(135deg, var(--bg-body) 0%, rgba(15, 44, 89, 0.04) 50%, var(--bg-body) 100%);
            min-height: 100vh;
        }
        .guest-bg::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle at 20% 30%, rgba(15, 44, 89, 0.06) 0%, transparent 45%),
                radial-gradient(circle at 80% 70%, rgba(197, 160, 89, 0.05) 0%, transparent 45%);
            pointer-events: none;
            z-index: 0;
        }
        .guest-brand-panel {
            background: linear-gradient(160deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%);
            border-radius: 1.5rem;
            color: white;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }
        .guest-brand-panel::after {
            content: '';
            position: absolute;
            width: 280px;
            height: 280px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            top: -80px;
            right: -80px;
            pointer-events: none;
        }
        .guest-brand-panel .lead { color: rgba(255,255,255,0.9); }
        .guest-brand-panel .text-white-50 { color: rgba(255,255,255,0.7) !important; }
    </style>
</head>

<body class="min-vh-100">

    <div class="guest-bg position-relative">
        <nav class="navbar navbar-glass fixed-top py-3 mx-3 rounded-3 position-relative z-3">
            <div class="container">
                <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px;">
                        <i class="fas fa-cube fs-5"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="fw-bold fs-5 tracking-tight text-main lh-1">Land <span class="text-gradient-primary">Coin</span></span>
                        <span class="small text-muted fw-medium ls-1" style="font-size: 0.65rem;">DIGITAL REAL ESTATE</span>
                    </div>
                </a>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('login') }}" class="btn btn-glass btn-sm rounded-pill px-3 fw-bold text-main">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">Sign up</a>
                </div>
            </div>
        </nav>

        <main class="min-vh-100 d-flex align-items-center py-5 position-relative z-1" style="padding-top: 5.5rem !important;">
            <div class="container py-4">
                {{ $slot }}
            </div>
        </main>
    </div>

</body>

</html>
