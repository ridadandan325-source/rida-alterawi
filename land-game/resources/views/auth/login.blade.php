<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <svg class="text-success" width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <h2 class="h3 fw-bold mb-2">تسجيل الدخول</h2>
                    <p class="text-muted">مرحباً بعودتك! سجل دخولك للمتابعة</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="alert alert-success mb-4" :status="session('status')" />

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">البريد الإلكتروني</label>
                                <input 
                                    id="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autofocus 
                                    autocomplete="username"
                                    placeholder="أدخل بريدك الإلكتروني">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">كلمة المرور</label>
                                <input 
                                    id="password" 
                                    class="form-control @error('password') is-invalid @enderror"
                                    type="password"
                                    name="password"
                                    required 
                                    autocomplete="current-password"
                                    placeholder="أدخل كلمة المرور">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                    <label class="form-check-label" for="remember_me">
                                        تذكرني
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none text-success" href="{{ route('password.request') }}">
                                        نسيت كلمة المرور؟
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                                تسجيل الدخول
                            </button>

                            <!-- Register Link -->
                            <div class="text-center mt-4 pt-4 border-top">
                                <p class="text-muted mb-0">
                                    ليس لديك حساب؟
                                    <a href="{{ route('register') }}" class="text-success text-decoration-none fw-semibold">
                                        إنشاء حساب جديد
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
