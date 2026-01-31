<x-guest-layout>
  {{-- Mobile: short intro above form --}}
  <div class="text-center mb-4 d-lg-none">
    <h2 class="h5 fw-bold text-main font-serif mb-2">Join Land Coin</h2>
    <p class="text-muted small mb-0">Create a free account to buy and own digital lands.</p>
  </div>

  <div class="row g-4 align-items-center justify-content-center">
    {{-- Left: Branding & benefits --}}
    <div class="col-lg-5 d-none d-lg-block">
      <div class="guest-brand-panel h-100 d-flex flex-column justify-content-between">
        <div class="position-relative z-1">
          <div class="d-inline-flex align-items-center gap-2 rounded-pill bg-white bg-opacity-15 px-3 py-2 mb-4">
            <i class="fas fa-coins text-white"></i>
            <span class="small fw-bold text-white">LNDC — Land Coin</span>
          </div>
          <h1 class="display-6 fw-bold text-white font-serif mb-3 lh-sm">
            Start owning digital lands today
          </h1>
          <p class="lead mb-4 opacity-90">
            Create your account to explore the map, top up your wallet, and acquire exclusive land assets.
          </p>
          <ul class="list-unstyled mb-0">
            <li class="d-flex align-items-center gap-3 mb-3 text-white-50">
              <div class="rounded-circle bg-white bg-opacity-15 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="fas fa-user-plus text-white"></i>
              </div>
              <span>Free account — no fees to join</span>
            </li>
            <li class="d-flex align-items-center gap-3 mb-3 text-white-50">
              <div class="rounded-circle bg-white bg-opacity-15 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="fas fa-map-marked-alt text-white"></i>
              </div>
              <span>Browse & buy lands on the map</span>
            </li>
            <li class="d-flex align-items-center gap-3 text-white-50">
              <div class="rounded-circle bg-white bg-opacity-15 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="fas fa-lock text-white"></i>
              </div>
              <span>Secure wallet & ownership records</span>
            </li>
          </ul>
        </div>
        <p class="small text-white-50 mb-0 mt-4 position-relative z-1">Land Coin — Digital Lands Platform</p>
      </div>
    </div>

    {{-- Right: Register form --}}
    <div class="col-lg-5 col-md-8">
      <div class="card card-ui border-0 shadow-lg overflow-hidden">
        <div class="p-4 text-center text-white rounded-top-3" style="background: linear-gradient(135deg, var(--primary-dark), var(--primary));">
          <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white bg-opacity-15 w-56px h-56px border border-white border-opacity-20 mb-3">
            <i class="fas fa-user-plus fa-xl text-white"></i>
          </div>
          <h2 class="h4 fw-bold mb-1 text-white font-serif">Create account</h2>
          <p class="small text-white-50 mb-0 ls-1 text-uppercase fw-bold">Join Land Coin</p>
        </div>

        <div class="card-body p-4">
          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
              <x-input-label for="name" :value="__('Full Name')" class="small fw-bold text-muted text-uppercase ls-1 mb-2" />
              <div class="input-group rounded-3 overflow-hidden border border-glass">
                <span class="input-group-text bg-body border-0 text-muted ps-3"><i class="fas fa-user"></i></span>
                <x-text-input id="name" class="form-control border-0 ps-2" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Your name" />
              </div>
              <x-input-error :messages="$errors->get('name')" class="mt-1 small text-danger fw-bold" />
            </div>

            <div class="mb-3">
              <x-input-label for="email" :value="__('Email')" class="small fw-bold text-muted text-uppercase ls-1 mb-2" />
              <div class="input-group rounded-3 overflow-hidden border border-glass">
                <span class="input-group-text bg-body border-0 text-muted ps-3"><i class="fas fa-envelope"></i></span>
                <x-text-input id="email" class="form-control border-0 ps-2" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
              </div>
              <x-input-error :messages="$errors->get('email')" class="mt-1 small text-danger fw-bold" />
            </div>

            <div class="mb-3">
              <x-input-label for="password" :value="__('Password')" class="small fw-bold text-muted text-uppercase ls-1 mb-2" />
              <div class="input-group rounded-3 overflow-hidden border border-glass">
                <span class="input-group-text bg-body border-0 text-muted ps-3"><i class="fas fa-lock"></i></span>
                <x-text-input id="password" class="form-control border-0 ps-2" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
              </div>
              <x-input-error :messages="$errors->get('password')" class="mt-1 small text-danger fw-bold" />
            </div>

            <div class="mb-4">
              <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="small fw-bold text-muted text-uppercase ls-1 mb-2" />
              <div class="input-group rounded-3 overflow-hidden border border-glass">
                <span class="input-group-text bg-body border-0 text-muted ps-3"><i class="fas fa-check-circle"></i></span>
                <x-text-input id="password_confirmation" class="form-control border-0 ps-2" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
              </div>
              <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 small text-danger fw-bold" />
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold hover-scale">
              Create account <i class="fas fa-arrow-right ms-2 small"></i>
            </button>
          </form>

          <hr class="my-4 border-glass">

          <p class="text-center text-muted small mb-0">
            Already have an account?
            <a href="{{ route('login') }}" class="fw-bold text-primary text-decoration-none">Log in</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</x-guest-layout>
