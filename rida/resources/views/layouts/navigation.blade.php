<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 dark:bg-gray-950 dark:border-white/10">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <!-- Dashboard -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- My Lands -->
                    @if(Route::has('lands.index'))
                        <x-nav-link :href="route('lands.index')" :active="request()->routeIs('lands.*')">
                            My Lands
                        </x-nav-link>
                    @endif

                    <!-- Public Map (Preview Map) -->
                    <x-nav-link :href="url('/map')" :active="request()->is('map')">
                        Public Map
                    </x-nav-link>

                    <!-- My Purchases -->
                    @if(Route::has('purchases.index'))
                        <x-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.index')">
                            My Purchases
                        </x-nav-link>
                    @endif

                    <!-- My Sales -->
                    @if(Route::has('sales.index'))
                        <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')">
                            My Sales
                        </x-nav-link>
                    @endif

                    <!-- ✅ Theme Toggle (Desktop) -->
                    <button id="themeToggle"
                        class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-sm font-semibold
                               dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10 dark:text-white">
                        <span id="themeIcon">🌙</span>
                        <span id="themeText">Dark</span>
                    </button>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md
                                       text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150
                                       dark:bg-transparent dark:text-gray-200 dark:hover:text-white">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100
                               focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out
                               dark:hover:bg-white/10 dark:focus:bg-white/10 dark:focus:text-white">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Route::has('lands.index'))
                <x-responsive-nav-link :href="route('lands.index')" :active="request()->routeIs('lands.*')">
                    My Lands
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="url('/map')" :active="request()->is('map')">
                Public Map
            </x-responsive-nav-link>

            @if(Route::has('purchases.index'))
                <x-responsive-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.index')">
                    My Purchases
                </x-responsive-nav-link>
            @endif

            @if(Route::has('sales.index'))
                <x-responsive-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')">
                    My Sales
                </x-responsive-nav-link>
            @endif

            <!-- ✅ Theme Toggle (Mobile) -->
            <div class="px-3">
                <button id="themeToggleMobile"
                    class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-sm font-semibold
                           dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10 dark:text-white">
                    <span id="themeIconMobile">🌙</span>
                    <span id="themeTextMobile">Dark</span>
                </button>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-white/10">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    <!-- ✅ Theme Toggle Script -->
    <script>
        function getTheme() {
            return localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        }

        function applyTheme(theme) {
            localStorage.setItem('theme', theme);
            document.documentElement.classList.toggle('dark', theme === 'dark');

            const isDark = theme === 'dark';
            const icon = isDark ? '☀️' : '🌙';
            const text = isDark ? 'Light' : 'Dark';

            const iconEl = document.getElementById('themeIcon');
            const textEl = document.getElementById('themeText');
            const iconElM = document.getElementById('themeIconMobile');
            const textElM = document.getElementById('themeTextMobile');

            if (iconEl) iconEl.textContent = icon;
            if (textEl) textEl.textContent = text;
            if (iconElM) iconElM.textContent = icon;
            if (textElM) textElM.textContent = text;

            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme } }));
        }

        function toggleTheme() {
            const t = getTheme();
            applyTheme(t === 'dark' ? 'light' : 'dark');
        }

        document.addEventListener('DOMContentLoaded', () => {
            applyTheme(getTheme());

            const btn = document.getElementById('themeToggle');
            const btnM = document.getElementById('themeToggleMobile');

            if (btn) btn.addEventListener('click', toggleTheme);
            if (btnM) btnM.addEventListener('click', toggleTheme);
        });
    </script>
</nav>
