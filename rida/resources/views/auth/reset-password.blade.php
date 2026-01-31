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
                        🔁
                    </div>
                </div>
                <h2 class="text-white fw-bold mb-2 h3 font-serif tracking-tight">
                    Reset Password
                </h2>
                <p class="text-white opacity-75 mb-0 small ls-1 text-uppercase fw-bold">
                    Create a new secure password
                </p>
            </div>
        </div>

        <div class="card-body p-5 pt-4">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email address')" class="small fw-bold text-muted text-uppercase ls-1 mb-2" />
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <x-text-input id="email" class="form-control border-start-0 ps-2" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 small text-danger fw-bold" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('New Password')" class="small fw-bold text-muted text-uppercase ls-1 mb-2" />
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                            <i class="fas fa-lock"></i>
                        </span>
                        <x-text-input id="password" class="form-control border-start-0 ps-2" type="password" name="password" required autocomplete="new-password" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 small text-danger fw-bold" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="small fw-bold text-muted text-uppercase ls-1 mb-2" />
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                            <i class="fas fa-lock"></i>
                        </span>
                        <x-text-input id="password_confirmation" class="form-control border-start-0 ps-2" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 small text-danger fw-bold" />
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button type="submit" class="btn w-100 fw-bold py-3 text-white border-0 shadow-lg btn-primary hover-scale rounded-pill d-flex align-items-center justify-content-center gap-2">
                        <span>Reset Password</span> <i class="fas fa-check-circle small"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>