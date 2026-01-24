<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
                    Public Map
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                    Explore lands for sale on the interactive map.
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('lands.index') }}"
                   class="inline-flex items-center rounded-xl bg-black px-4 py-2 text-white font-semibold hover:opacity-90">
                    My Lands
                </a>

                <a href="{{ route('purchases.index') }}"
                   class="inline-flex items-center rounded-xl border border-gray-200 bg-white px-4 py-2 font-semibold hover:bg-gray-50
                          dark:bg-white/5 dark:border-white/10 dark:text-white dark:hover:bg-white/10">
                    Purchases
                </a>

                <a href="{{ route('sales.index') }}"
                   class="inline-flex items-center rounded-xl border border-gray-200 bg-white px-4 py-2 font-semibold hover:bg-gray-50
                          dark:bg-white/5 dark:border-white/10 dark:text-white dark:hover:bg-white/10">
                    Sales
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Filters --}}
    <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-3">
        <input id="q" placeholder="Search by title..."
               class="rounded-2xl border border-gray-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-black/10
                      dark:bg-white/5 dark:border-white/10 dark:text-white dark:placeholder:text-gray-400"/>

        <input id="minPrice" type="number" step="0.01" placeholder="Min price"
               class="rounded-2xl border border-gray-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-black/10
                      dark:bg-white/5 dark:border-white/10 dark:text-white dark:placeholder:text-gray-400"/>

        <input id="maxPrice" type="number" step="0.01" placeholder="Max price"
               class="rounded-2xl border border-gray-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-black/10
                      dark:bg-white/5 dark:border-white/10 dark:text-white dark:placeholder:text-gray-400"/>

        <div class="flex gap-2">
            <button id="resetBtn"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 font-semibold hover:bg-gray-50
                           dark:bg-white/5 dark:border-white/10 dark:text-white dark:hover:bg-white/10">
                Reset
            </button>
            <div id="resultsHint"
                 class="w-full rounded-2xl bg-gray-900 text-white px-4 py-3 font-semibold text-center dark:bg-white/10">
                Showing all
            </div>
        </div>
    </div>

    {{-- Map card --}}
    <div class="rounded-3xl border border-gray-200 bg-white shadow-sm overflow-hidden dark:bg-white/5 dark:border-white/10">
        <div id="map" class="h-[70vh] w-full"></div>
    </div>

    <style>
        /* Glow Marker */
        .glow-pin {
            width: 14px;
            height: 14px;
            border-radius: 999px;
            background: #8b5cf6;
            box-shadow: 0 0 10px rgba(139,92,246,.9), 0 0 22px rgba(139,92,246,.6);
            position: relative;
        }
        .glow-pin::after {
            content: "";
            position: absolute;
            inset: -10px;
            border-radius: 999px;
            background: rgba(139,92,246,.18);
            animation: pulse 1.8s ease-out infinite;
        }
        @keyframes pulse {
            0%   { transform: scale(0.2); opacity: 0.9; }
            100% { transform: scale(1.2); opacity: 0; }
        }

        /* Dark popup */
        .dark .leaflet-popup-content-wrapper,
        .dark .leaflet-popup-tip {
            background: #0b1220 !important;
            color: #e5e7eb !important;
        }
        .dark .leaflet-container a {
            color: #e5e7eb;
        }
    </style>

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([31.9539, 35.9106], 11);

        // Light/Dark tiles
        const lightTiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        });

        const darkTiles = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap &copy; CARTO'
        });

        let activeTiles = null;

        function currentTheme() {
            return localStorage.getItem('theme') ||
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        }

        function setMapTheme(theme) {
            if (activeTiles) map.removeLayer(activeTiles);
            activeTiles = (theme === 'dark') ? darkTiles : lightTiles;
            activeTiles.addTo(map);
        }

        // start
        setMapTheme(currentTheme());

        // listen to navbar toggle
        window.addEventListener('theme-changed', (e) => {
            setMapTheme(e.detail.theme);
        });

        const lands = @json($lands);
        const focusId = @json($focus ?? null);

        const isAuth = @json(auth()->check());

        const markers = {};
        const markerData = {};

        // Glow icon
        const glowIcon = L.divIcon({
            className: '',
            html: '<div class="glow-pin"></div>',
            iconSize: [14, 14],
            iconAnchor: [7, 7]
        });

        function popupHtml(land) {
            const price = Number(land.price).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            const actionHtml = isAuth
                ? `
                    <a href="/checkout/${land.id}" style="
                        display:block;
                        width:100%;
                        margin-top:10px;
                        padding:10px 12px;
                        border-radius:14px;
                        border:1px solid #111;
                        background:#111;
                        color:#fff;
                        font-weight:700;
                        text-align:center;
                        text-decoration:none;
                        cursor:pointer;
                    ">Proceed to Checkout</a>
                  `
                : `
                    <a href="{{ route('login') }}" style="
                        display:block;
                        width:100%;
                        margin-top:10px;
                        padding:10px 12px;
                        border-radius:14px;
                        border:1px solid #ddd;
                        background:#fff;
                        color:#111;
                        font-weight:700;
                        text-align:center;
                        text-decoration:none;
                    ">Login to Buy</a>
                  `;

            return `
                <div style="min-width:220px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;">
                        <b style="font-size:14px;">${land.title}</b>
                        <span style="font-size:11px;padding:4px 8px;border-radius:999px;background:#e9fbe9;color:#0f6a0f;border:1px solid #c7f0c7;">For Sale</span>
                    </div>
                    <div style="color:#666;font-size:12px;margin-top:6px;">${land.description ?? ''}</div>
                    <div style="display:flex;justify-content:space-between;margin-top:10px;">
                        <span style="color:#666;font-size:12px;">Price</span>
                        <b>${price}</b>
                    </div>
                    ${actionHtml}
                </div>
            `;
        }

        // Create markers with glow icon
        lands.forEach(land => {
            const marker = L.marker([land.lat, land.lng], { icon: glowIcon })
                .addTo(map)
                .bindPopup(popupHtml(land));

            markers[land.id] = marker;
            markerData[land.id] = land;
        });

        // Focus
        if (focusId && markers[focusId]) {
            const m = markers[focusId];
            map.setView(m.getLatLng(), 15);
            m.openPopup();
        }

        // Filters
        const qEl = document.getElementById('q');
        const minEl = document.getElementById('minPrice');
        const maxEl = document.getElementById('maxPrice');
        const resetBtn = document.getElementById('resetBtn');
        const resultsHint = document.getElementById('resultsHint');

        function matches(land, q, minP, maxP) {
            const title = (land.title ?? '').toLowerCase();
            if (q && !title.includes(q)) return false;

            const price = Number(land.price ?? 0);
            if (minP !== null && price < minP) return false;
            if (maxP !== null && price > maxP) return false;
            return true;
        }

        function applyFilters() {
            const q = qEl.value.trim().toLowerCase();
            const minP = minEl.value.trim() === '' ? null : Number(minEl.value);
            const maxP = maxEl.value.trim() === '' ? null : Number(maxEl.value);

            let shown = 0;

            Object.keys(markers).forEach(id => {
                const land = markerData[id];
                const marker = markers[id];
                const ok = matches(land, q, minP, maxP);

                if (ok) {
                    if (!map.hasLayer(marker)) marker.addTo(map);
                    shown++;
                } else {
                    if (map.hasLayer(marker)) map.removeLayer(marker);
                }
            });

            resultsHint.textContent = `Showing ${shown} of ${lands.length}`;
        }

        qEl.addEventListener('input', applyFilters);
        minEl.addEventListener('input', applyFilters);
        maxEl.addEventListener('input', applyFilters);

        resetBtn.addEventListener('click', () => {
            qEl.value = '';
            minEl.value = '';
            maxEl.value = '';
            applyFilters();
        });
    </script>
</x-app-layout>
