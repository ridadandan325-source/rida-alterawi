<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <svg class="text-success" width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="h3 fw-bold mb-2">تحقق من بريدك الإلكتروني</h2>
                    <p class="text-muted">شكراً لتسجيلك! قبل البدء، يرجى التحقق من بريدك الإلكتروني بالنقر على الرابط الذي أرسلناه إليك</p>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success mb-4">
                                <p class="mb-0">تم إرسال رابط تحقق جديد إلى بريدك الإلكتروني.</p>
                            </div>
                        @endif

                        <div class="d-flex flex-column gap-3">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                                    إعادة إرسال رابط التحقق
                                </button>
                            </form>

                            <form method="POST" action="{{ route('logout') }}" class="pt-3 border-top">
                                @csrf
                                <button type="submit" class="btn btn-link text-muted w-100 text-decoration-none">
                                    تسجيل الخروج
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
