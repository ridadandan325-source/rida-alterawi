<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <svg class="text-success" width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <h2 class="h3 fw-bold mb-2">نسيت كلمة المرور؟</h2>
                    <p class="text-muted">لا مشكلة. أخبرنا بريدك الإلكتروني وسنرسل لك رابط إعادة تعيين كلمة المرور</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="alert alert-success mb-4" :status="session('status')" />

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('password.email') }}">
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
                                    placeholder="أدخل بريدك الإلكتروني">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                                إرسال رابط إعادة تعيين كلمة المرور
                            </button>

                            <!-- Back to Login -->
                            <div class="text-center mt-4 pt-4 border-top">
                                <a href="{{ route('login') }}" class="text-success text-decoration-none fw-semibold">
                                    العودة لتسجيل الدخول
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
