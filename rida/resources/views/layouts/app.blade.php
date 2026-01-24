<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- ✅ Apply theme BEFORE render (prevents flash) -->
        <script>
            (function () {
                const saved = localStorage.getItem('theme');
                const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                const theme = saved || (prefersDark ? 'dark' : 'light');
                document.documentElement.classList.toggle('dark', theme === 'dark');
            })();
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased bg-gradient-to-b from-gray-50 via-white to-gray-50 text-gray-900
                 dark:bg-gradient-to-b dark:from-gray-950 dark:via-gray-950 dark:to-gray-950 dark:text-gray-100">

        <div class="min-h-screen">
            @include('layouts.navigation')

            @if (isset($header))
                <header class="bg-white/70 backdrop-blur border-b border-gray-200
                               dark:bg-gray-950/60 dark:border-white/10">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                {{-- ✅ Global toast (success / error) --}}
                @if(session('success'))
                    <div id="toast"
                         class="fixed top-4 right-4 z-50 rounded-2xl bg-black text-white px-4 py-3 shadow-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div id="toast"
                         class="fixed top-4 right-4 z-50 rounded-2xl bg-red-700 text-white px-4 py-3 shadow-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const t = document.getElementById('toast');
                        if (t) setTimeout(() => t.remove(), 3000);
                    });
                </script>

                {{ $slot }}

            </main>
        </div>
    </body>
</html>
