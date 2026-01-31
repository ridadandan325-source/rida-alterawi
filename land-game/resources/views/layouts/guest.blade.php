<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Land Game') }} - {{ $title ?? 'لعبة الأراضي' }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-light">
        <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-5 px-3">
            <div class="mb-4">
                <a href="/" class="text-decoration-none d-flex align-items-center">
                    <div class="bg-success rounded p-2 me-2" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <svg class="text-white" width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <span class="h4 fw-bold text-success mb-0">Land Game</span>
                </a>
            </div>

            <div class="w-100" style="max-width: 500px;">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
