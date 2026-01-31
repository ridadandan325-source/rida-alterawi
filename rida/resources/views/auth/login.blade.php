<x-guest-layout>
  {{-- Mobile: short intro above form --}}
  <div class="text-center mb-4 d-lg-none">
    <h2 class="h5 fw-bold text-main font-serif mb-2">Welcome to Land Coin</h2>
    <p class="text-muted small mb-0">Sign in to explore the map and manage your digital lands.</p>
  </div>

  <div class="row g-4 align-items-center justify-content-center">
    {{-- Left: Branding & benefits (hidden on small screens) --}}
    <div class="col-lg-5 d-none d-lg-block">
      <div class="guest-brand-panel h-100 d-flex flex-column justify-content-between">
        <div class="position-relative z-1">
          <div class="d-inline-flex align-items-center gap-2 rounded-pill bg-white bg-opacity-15 px-3 py-2 mb-4">
            <i class="fas fa-map-marked-alt text-white"></i>
            <span class="small fw-bold text-white">Digital Real Estate</span>
          </div>
          <h1 class="display-6 fw-bold text-white font-serif mb-3 lh-sm">
            Own your piece of the digital world
          </h1>
          <p class="lead mb-4 opacity-90">
            Sign in to explore the map, buy lands with LNDC, and manage your portfolio.
          </p>
          <ul class="list-unstyled mb-0">
            <li class="d-flex align-items-center gap-3 mb-3 text-white-50">
              <div class="rounded-circle bg-white bg-opacity-15 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="fas fa-globe text-white"></i>
              </div>
              <span>Explore lands on an interactive map</span>
            </li>
            <li class="d-flex align-items-center gap-3 mb-3 text-white-50">
              <div class="rounded-circle bg-white bg-opacity-15 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="fas fa-wallet text-white"></i>
              </div>
              <span>Pay with LNDC — secure wallet</span>
            </li>
            <li class="d-flex align-items-center gap-3 text-white-50">
              <div class="rounded-circle bg-white bg-opacity-15 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="fas fa-shield-alt text-white"></i>
              </div>
              <span>Verified ownership & transactions</span>
            </li>
          </ul>
        </div>
        <p class="small text-white-50 mb-0 mt-4 position-relative z-1">Land Coin — Digital Lands Platform</p>
      </div>
    </div>

    {{-- Right: Login form --}}
    <div class="col-lg-4 col-md-8">
      <div class="card card-ui border-0 shadow-lg overflow-hidden">
        <div class="p-4 text-center text-white rounded-top-3" style="background: linear-gradient(135deg, var(--primary-dark), var(--primary));">
          <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white bg-opacity-15 w-56px h-56px border border-white border-opacity-20 mb-3">
            <i class="fas fa-lock fa-xl text-white"></i>
          </div>
          <h2 class="h4 fw-bold mb-1 text-white font-serif">Welcome back</h2>
          <p class="small text-white-50 mb-0 ls-1 text-uppercase fw-bold">Sign in to Land Coin</p>
        </div>

        <div class="card-body p-4">
          <x-auth-session-status class="mb-3 alert alert-success border-0 small fw-bold rounded-3" :status="session('status')" />

          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
              <x-input-label for="email" :value="__('Email')" class="small fw-bold text-muted text-uppercase ls-1 mb-2" />
              <div class="input-group rounded-3 overflow-hidden border border-glass">
                <span class="input-group-text bg-body border-0 text-muted ps-3"><i class="fas fa-envelope"></i></span>
                <x-text-input id="email" class="form-control border-0 ps-2" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
              </div>
              <x-input-error :messages="$errors->get('email')" class="mt-1 small text-danger fw-bold" />
            </div>

            <div class="mb-3">
              <x-input-label for="password" :value="__('Password')" class="small fw-bold text-muted text-uppercase ls-1 mb-2" />
              <div class="input-group rounded-3 overflow-hidden border border-glass">
                <span class="input-group-text bg-body border-0 text-muted ps-3"><i class="fas fa-lock"></i></span>
                <x-text-input id="password" class="form-control border-0 ps-2" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
              </div>
              <x-input-error :messages="$errors->get('password')" class="mt-1 small text-danger fw-bold" />
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label text-muted small">Remember me</label>
              </div>
              @if (Route::has('password.request'))
                <a class="small fw-bold text-primary text-decoration-none" href="{{ route('password.request') }}">Forgot password?</a>
              @endif
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold hover-scale">
              Sign in <i class="fas fa-arrow-right ms-2 small"></i>
            </button>
          </form>

          <hr class="my-4 border-glass">

          <p class="text-center text-muted small mb-0">
            Don't have an account?
            <a href="{{ route('register') }}" class="fw-bold text-primary text-decoration-none">Create account</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</x-guest-layout>
