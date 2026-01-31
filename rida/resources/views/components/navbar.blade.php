@php
    $route = request()->route()?->getName();
@endphp

<nav class="navbar navbar-expand-lg fixed-top glass-effect border-bottom border-glass shadow-sm">
    <div class="container">
        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" class="navbar-brand d-flex align-items-center gap-3 text-decoration-none">
            <div class="d-flex align-items-center justify-content-center text-white fw-bold rounded-3 shadow-lg bg-primary bg-opacity-25"
                style="width: 48px; height: 48px;">
                🌍
            </div>
            <div>
                <div class="fw-bold text-main font-serif lh-1" style="font-size: 1.1rem; letter-spacing: 0.5px;">
                    Land <span class="text-primary">Coin</span>
                </div>
                <div class="small text-muted" style="font-size: 0.7rem;">
                    Digital Real-Estate Platform
                </div>
            </div>
        </a>

        <button class="navbar-toggler border-glass" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            {{-- Links --}}
            <ul class="navbar-nav ms-auto me-4 gap-2">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ $route === 'dashboard' ? 'active bg-glass-light text-primary fw-bold' : 'text-muted' }} px-3 rounded-3">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('lands.index') }}"
                        class="nav-link {{ str_starts_with($route ?? '', 'lands') ? 'active bg-glass-light text-primary fw-bold' : 'text-muted' }} px-3 rounded-3">
                        My Lands
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('purchases.index') }}"
                        class="nav-link {{ str_starts_with($route ?? '', 'purchases') ? 'active bg-glass-light text-primary fw-bold' : 'text-muted' }} px-3 rounded-3">
                        Purchases
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('map') }}"
                        class="nav-link {{ $route === 'map' ? 'active bg-glass-light text-primary fw-bold' : 'text-muted' }} px-3 rounded-3">
                        Map
                    </a>
                </li>
                @auth
                    @if(auth()->user()->is_admin)
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ str_starts_with($route ?? '', 'admin.') ? 'active bg-warning bg-opacity-10 text-warning fw-bold' : 'text-muted' }} px-3 rounded-3">
                                👑 Admin
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            {{-- User --}}
            <div class="d-flex align-items-center gap-3">
                {{-- Theme Toggle --}}
                <button id="themeToggle" class="btn btn-sm btn-glass text-main border-glass" title="Toggle Theme">
                    <span id="themeIcon">🌙</span>
                </button>

                @auth
                    {{-- Wallet Badge --}}
                    <div class="d-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-glass-light border-glass shadow-sm">
                        <span class="text-warning small fw-bold">🪙
                            {{ number_format((float) Auth::user()->wallet_balance, 2) }}</span>
                        <span class="text-muted small" style="font-size: 0.7rem;">LNDC</span>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-sm btn-glass border-glass rounded-pill d-flex align-items-center gap-2 ps-1 pe-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                             <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold bg-dark"
                                style="width: 32px; height: 32px; font-size: 0.75rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-main small fw-semibold">
                                {{ Auth::user()->name }}
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 bg-glass blur-md p-2">
                            <li><h6 class="dropdown-header text-muted small text-uppercase ls-1">Account</h6></li>
                            <li><a class="dropdown-item rounded-2 text-main" href="{{ route('profile.edit') }}"><i class="fas fa-user-circle me-2 text-primary"></i> Profile</a></li>
                            <li><hr class="dropdown-divider border-glass"></li>
                             <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item rounded-2 text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-glass btn-sm fw-bold px-3 text-main">LOGIN</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm fw-bold px-3 shadow-lg text-white">JOIN NOW</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;
        
        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);
        themeIcon.textContent = savedTheme === 'dark' ? '☀️' : '🌙';

        toggleBtn.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            themeIcon.textContent = newTheme === 'dark' ? '☀️' : '🌙';
        });
    });
</script>
