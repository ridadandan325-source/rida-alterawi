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
                        ✉️
                    </div>
                </div>
                <h2 class="text-white fw-bold mb-2 h3 font-serif tracking-tight">
                    Verify Email
                </h2>
                <p class="text-white opacity-75 mb-0 small ls-1 text-uppercase fw-bold">
                    One last step to get started
                </p>
            </div>
        </div>

        <div class="card-body p-5 pt-4">
            
            <div class="mb-4 text-center">
                <p class="text-muted small">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success border-0 shadow-sm bg-success bg-opacity-10 text-success fw-bold small mb-4 text-center">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div class="mb-3">
                    <button type="submit" class="btn w-100 fw-bold py-3 text-white border-0 shadow-lg btn-primary hover-scale rounded-pill d-flex align-items-center justify-content-center gap-2">
                        <span>Resend Verification Email</span> <i class="fas fa-paper-plane small"></i>
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <div class="text-center">
                    <button type="submit" class="btn btn-link text-decoration-none small fw-bold text-muted hover-scale">
                        <i class="fas fa-sign-out-alt me-1"></i> {{ __('Log Out') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>