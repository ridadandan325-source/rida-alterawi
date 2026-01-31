<x-guest-layout>
    <!-- Card -->
    <div class="card card-premium border-0 shadow-xl w-100 mw-450px overflow-hidden">
        
        <!-- Header with Gradient -->
        <div class="p-5 text-center position-relative overflow-hidden">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-night" style="z-index: 0;"></div>
            <div class="position-absolute top-0 end-0 translate-middle p-5 bg-gradient-primary opacity-50 rounded-circle blur-3xl" style="width: 150px; height: 150px;"></div>
            
            <div class="position-relative z-1">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white w-64px h-64px bg-white bg-opacity-10 fs-1 backdrop-blur-md shadow-lg border border-white border-opacity-20">
                        🔑
                    </div>
                </div>
                <h2 class="text-white fw-bold mb-2 h3 font-serif tracking-tight">
                    Forgot Password?
                </h2>
                <p class="text-white opacity-75 mb-0 small ls-1 text-uppercase fw-bold">
                    We'll help you get back in
                </p>
            </div>
        </div>

        <div class="card-body p-5 pt-4">
            
            <div class="mb-4 text-center">
                <p class="text-muted small">
                    {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-center small text-success fw-bold" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email address')" class="small fw-bold text-muted text-uppercase ls-1 mb-2" />
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <x-text-input id="email" class="form-control border-start-0 ps-2" type="email" name="email" :value="old('email')" required autofocus />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 small text-danger fw-bold" />
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button type="submit" class="btn w-100 fw-bold py-3 text-white border-0 shadow-lg btn-primary hover-scale rounded-pill d-flex align-items-center justify-content-center gap-2">
                        <span>Email Reset Link</span> <i class="fas fa-paper-plane small"></i>
                    </button>
                </div>

                <!-- Back to Login -->
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none small fw-bold text-muted hover-scale d-inline-block">
                        <i class="fas fa-arrow-left me-1"></i> Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>