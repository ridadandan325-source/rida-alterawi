<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Land Game') }} - لعبة الأراضي</title>
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-light">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <div class="bg-gradient rounded p-2 me-2" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <svg class="text-white" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <span class="fw-bold text-success">Land Game</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                    @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/dashboard') }}">لوحة التحكم</a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link nav-link text-danger">تسجيل الخروج</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">تسجيل الدخول</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-success ms-2" href="{{ route('register') }}">إنشاء حساب</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="pt-5 mt-5">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h1 class="display-3 fw-bold mb-4 text-success">مرحباً بك في لعبة الأراضي</h1>
                    <p class="lead text-muted mb-4">استمتع بتجربة فريدة من نوعها في إدارة وشراء الأراضي</p>
                    @guest
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ route('register') }}" class="btn btn-success btn-lg px-5">
                            ابدأ الآن مجاناً
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-success btn-lg px-5">
                            تسجيل الدخول
                        </a>
                    </div>
                    @endguest
                </div>

                <!-- Features Grid -->
                <div class="row g-4 mt-5">
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                    <svg class="text-success" width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="h4 fw-bold mb-3">سهولة الاستخدام</h3>
                                <p class="text-muted mb-0">واجهة مستخدم بسيطة وسهلة الاستخدام تجعل تجربتك ممتعة</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                    <svg class="text-info" width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="h4 fw-bold mb-3">نظام مالي متكامل</h3>
                                <p class="text-muted mb-0">إدارة أموالك بسهولة وشراء الأراضي بكل أمان</p>
                            </div>
                        </div>
                </div>

                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                    <svg class="text-primary" width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                                </div>
                                <h3 class="h4 fw-bold mb-3">لعب جماعي</h3>
                                <p class="text-muted mb-0">تنافس مع اللاعبين الآخرين وابن إمبراطوريتك</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </main>

        <!-- Footer -->
        <footer class="bg-white border-top mt-5 py-4">
            <div class="container text-center">
                <p class="text-muted mb-0">© {{ date('Y') }} Land Game. جميع الحقوق محفوظة.</p>
        </div>
        </footer>
    </body>
</html>
