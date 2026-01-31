<nav class="navbar navbar-expand-lg navbar-glass fixed-top rounded-3 mx-3 mt-2" style="transition: all 0.3s ease;">
    <div class="container-fluid px-3">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ auth()->check() ? route('dashboard') : url('/') }}">
            <div class="rounded-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                <i class="fas fa-cube"></i>
            </div>
            <span class="fw-bold fs-5 tracking-tight text-main font-serif lh-1">Land <span class="text-gradient-primary">Coin</span></span>
        </a>

        <!-- Hamburger -->
        <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <div class="p-2 bg-glass rounded-circle">
                <span class="navbar-toggler-icon"></span>
            </div>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1 d-none d-lg-flex align-items-center">
                <li class="nav-item">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-3 py-2 rounded-pill fw-medium">
                        <i class="fas fa-home me-2 opacity-75"></i> {{ __('Dashboard') }}
                    </x-nav-link>
                </li>
                @if(Route::has('lands.index'))
                <li class="nav-item">
                    <x-nav-link :href="route('lands.index')" :active="request()->routeIs('lands.*') && !request()->routeIs('admin.*')" class="px-3 py-2 rounded-pill fw-medium">
                        <i class="fas fa-layer-group me-2 opacity-75"></i> My Lands
                    </x-nav-link>
                </li>
                @endif

                <li class="nav-item">
                    <x-nav-link :href="route('map')" :active="request()->routeIs('map')" class="px-3 py-2 rounded-pill fw-medium">
                        <i class="fas fa-map-marked-alt me-2 opacity-75"></i> Map
                    </x-nav-link>
                </li>
                @if(Route::has('wallet.index'))
                <li class="nav-item">
                    <x-nav-link :href="route('wallet.index')" :active="request()->routeIs('wallet.*')" class="px-3 py-2 rounded-pill fw-medium">
                        <i class="fas fa-wallet me-2 opacity-75"></i> Wallet
                    </x-nav-link>
                </li>
                @endif
                @if(Route::has('purchases.index'))
                    <li class="nav-item">
                        <x-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.index')" class="px-3 py-2 rounded-pill fw-medium transition-all hover-scale">
                            <i class="fas fa-shopping-bag me-2 opacity-75"></i> Purchases
                        </x-nav-link>
                    </li>
                @endif

                @if(Route::has('sales.index'))
                    <li class="nav-item">
                        <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')" class="px-3 py-2 rounded-pill fw-medium transition-all hover-scale">
                            <i class="fas fa-coins me-2 opacity-75"></i> Sales
                        </x-nav-link>
                    </li>
                @endif
            </ul>

            <!-- Mobile Menu (Visible only on mobile) -->
            <ul class="navbar-nav d-lg-none mb-3 gap-2 border-top border-glass pt-3 mt-2">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link px-3 py-2 rounded-3 fw-medium {{ request()->routeIs('dashboard') ? 'bg-primary text-white shadow-sm' : 'text-main hover-bg-glass' }}">
                        <i class="fas fa-home me-2 opacity-75 w-20px"></i> Dashboard
                    </a>
                </li>

                @if(Route::has('lands.index'))
                <li class="nav-item">
                    <a href="{{ route('lands.index') }}" class="nav-link px-3 py-2 rounded-3 fw-medium {{ request()->routeIs('lands.*') ? 'bg-primary text-white shadow-sm' : 'text-main hover-bg-glass' }}">
                        <i class="fas fa-layer-group me-2 opacity-75 w-20px"></i> My Lands
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('map') }}" class="nav-link px-3 py-2 rounded-3 fw-medium {{ request()->routeIs('map') ? 'bg-primary text-white shadow-sm' : 'text-main hover-bg-glass' }}">
                        <i class="fas fa-map-marked-alt me-2 opacity-75"></i> Map
                    </a>
                </li>
                @if(Route::has('wallet.index'))
                <li class="nav-item">
                    <a href="{{ route('wallet.index') }}" class="nav-link px-3 py-2 rounded-3 fw-medium {{ request()->routeIs('wallet.*') ? 'bg-primary text-white shadow-sm' : 'text-main hover-bg-glass' }}">
                        <i class="fas fa-wallet me-2 opacity-75"></i> Wallet
                    </a>
                </li>
                @endif
                @if(Route::has('purchases.index'))
                <li class="nav-item">
                    <a href="{{ route('purchases.index') }}" class="nav-link px-3 py-2 rounded-3 fw-medium {{ request()->routeIs('purchases.index') ? 'bg-primary text-white shadow-sm' : 'text-main hover-bg-glass' }}">
                        <i class="fas fa-shopping-bag me-2 opacity-75"></i> Purchases
                    </a>
                </li>
                @endif

                @if(Route::has('sales.index'))
                <li class="nav-item">
                    <a href="{{ route('sales.index') }}" class="nav-link px-3 py-2 rounded-3 fw-medium {{ request()->routeIs('sales.index') ? 'bg-primary text-white shadow-sm' : 'text-main hover-bg-glass' }}">
                        <i class="fas fa-coins me-2 opacity-75 w-20px"></i> Sales
                    </a>
                </li>
                @endif
            </ul>

            <!-- Right Side -->
            <div class="d-flex align-items-center gap-3 justify-content-end">
                <!-- Theme Toggle -->
                <button id="themeToggle" class="btn btn-glass border-0 rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm hover-scale" style="width: 40px; height: 40px;">
                    <span id="themeIcon" class="fs-5">🌙</span>
                </button>

                @auth
                    <!-- Wallet Badge -->
                    <a href="{{ route('wallet.index') }}" class="btn btn-glass rounded-pill px-3 py-1 d-flex align-items-center gap-2 border-0 shadow-sm hover-scale group">
                        <span class="bg-warning bg-gradient rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 24px; height: 24px;">🪙</span> 
                        <span class="fw-bold text-main">{{ number_format(Auth::user()->wallet_balance, 2) }}</span>
                    </a>

                    <!-- Settings Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-glass rounded-pill ps-1 pe-3 py-1 d-flex align-items-center gap-2 shadow-sm border-0 hover-scale" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 32px; height: 32px;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-xl border-0 rounded-4 mt-3 p-2 card-glass" aria-labelledby="userDropdown" style="min-width: 240px;">
                            <li class="px-3 py-2 mb-2 border-bottom border-secondary border-opacity-10">
                                <div class="small text-uppercase text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 0.05em;">Signed in as</div>
                                <div class="fw-bold text-main text-truncate font-serif">{{ Auth::user()->name }}</div>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 rounded-3 fw-medium d-flex align-items-center gap-2" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-circle opacity-50"></i> {{ __('Profile') }}
                                </a>
                            </li>
                            @if(auth()->user()->is_admin ?? false)
                            <li>
                                <a class="dropdown-item py-2 rounded-3 fw-medium d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-shield-alt opacity-50"></i> Admin Panel
                                </a>
                            </li>
                            @endif
                            <li><hr class="dropdown-divider my-2 border-secondary border-opacity-10"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item py-2 rounded-3 fw-medium text-danger d-flex align-items-center gap-2" type="submit">
                                        <i class="fas fa-sign-out-alt opacity-50"></i> {{ __('Log Out') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-glass px-4 rounded-pill fw-bold hover-scale">Log in</a>
                        <a href="{{ route('register') }}" class="btn btn-primary px-4 rounded-pill fw-bold shadow-lg hover-scale">Get Started</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    
    <!-- Theme Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('themeToggle');
            const icon = document.getElementById('themeIcon');
            const html = document.documentElement;
            
            // Check local storage or system preference
            const savedTheme = localStorage.getItem('theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (savedTheme === 'dark' || (!savedTheme && systemDark)) {
                html.setAttribute('data-bs-theme', 'dark');
                icon.textContent = '☀️';
            }
            
            toggle.addEventListener('click', function() {
                if (html.getAttribute('data-bs-theme') === 'dark') {
                    html.setAttribute('data-bs-theme', 'light');
                    localStorage.setItem('theme', 'light');
                    icon.textContent = '🌙';
                } else {
                    html.setAttribute('data-bs-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                    icon.textContent = '☀️';
                }
            });
        });
    </script>
</nav>