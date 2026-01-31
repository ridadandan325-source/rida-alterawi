<x-app-layout>
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
        <div>
            <h1 class="page-title display-6 fw-bold mb-1 text-gradient-primary">Map</h1>
            <p class="page-subtitle mb-0">Explore digital land assets on the grid.</p>
        </div>
        <div class="d-none d-md-flex align-items-center gap-2 px-4 py-2 rounded-pill card-ui border-glass">
            <span class="small text-muted fw-bold text-uppercase ls-1">Balance</span>
            <span class="fw-bold text-main d-flex align-items-center gap-2">
                <span class="rounded-circle bg-gradient-accent text-white d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.85rem;">🪙</span>
                {{ number_format((float) Auth::user()->wallet_balance, 2) }} <span class="text-muted fs-7">LNDC</span>
            </span>
        </div>
    </div>

    <div class="card card-ui border-0 overflow-hidden shadow-sm rounded-3">
        <div class="card-body p-0 position-relative">
            <div id="map" style="height: 75vh; width: 100%;"></div>
            <div class="position-absolute bottom-0 start-0 m-3 p-3 rounded-3 map-legend d-none d-sm-block card-ui border-glass" style="z-index: 400; min-width: 180px;">
                <h6 class="small fw-bold mb-2 text-main ls-1 text-uppercase">Legend</h6>
                <div class="d-flex align-items-center gap-2 mb-1 small text-muted">
                    <span class="rounded-circle bg-primary shadow-sm" style="width: 10px; height: 10px;"></span>
                    Admin listing
                </div>
                <div class="d-flex align-items-center gap-2 small text-muted">
                    <span class="rounded-circle bg-warning shadow-sm" style="width: 10px; height: 10px;"></span>
                    Resale
                </div>
            </div>
        </div>
    </div>

    {{-- Leaflet Assets --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // High-End Map Init
            const map = L.map('map', {
                zoomControl: false,
                attributionControl: false
            }).setView([31.9539, 35.9106], 12);

            // Light/Dark tiles based on theme
            const lightTiles = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                maxZoom: 20,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
            });
            
            const darkTiles = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 20,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
            });

            function updateMapTheme() {
                const theme = document.documentElement.getAttribute('data-bs-theme');
                const isDark = theme === 'dark';
                
                if (isDark) {
                    if (map.hasLayer(lightTiles)) map.removeLayer(lightTiles);
                    darkTiles.addTo(map);
                } else {
                    if (map.hasLayer(darkTiles)) map.removeLayer(darkTiles);
                    lightTiles.addTo(map);
                }
            }

            // Initial theme
            updateMapTheme();

            // Listen for theme changes (Bootstrap 5.3 uses data-bs-theme attribute)
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === "data-bs-theme") {
                        updateMapTheme();
                    }
                });
            });
            
            observer.observe(document.documentElement, { attributes: true });

            L.control.zoom({ position: 'topright' }).addTo(map);

            // Lands Data with Route Model Binding URLs
            const lands = @json($lands->map(function ($l) {
                return array_merge($l->toArray(), [
                    'checkout_url' => route('checkout.show', $l)
                ]);
            }));

            // Process and Add Markers
            lands.forEach(land => {
                if (!land.lat || !land.lng) return;

                const isResale = land.status === 'listed_owner';
                const color = isResale ? '#f59e0b' : '#4f46e5';

                const customIcon = L.divIcon({
                    className: 'custom-land-marker',
                    html: `
                        <div class="marker-container" style="--marker-color: ${color}">
                            <div class="marker-pulse" style="background-color: ${color}; box-shadow: 0 0 10px ${color};"></div>
                            <div class="marker-center" style="background-color: ${color};"></div>
                        </div>
                    `,
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });

                const popupContent = `
                    <div class="nft-popup card border-0 shadow-none bg-transparent" style="width: 260px;">
                        <div class="nft-header mb-3">
                             <span class="badge ${isResale ? 'bg-gradient-gold' : 'bg-gradient-primary'} shadow-sm x-small mb-2 px-2 py-1 rounded">
                                ${isResale ? 'RESALE' : 'GENESIS'}
                             </span>
                             <h6 class="fw-bold mb-0 mt-1 text-main font-serif">${land.title}</h6>
                             <code class="x-small text-muted">${land.land_id || 'ID UNASSIGNED'}</code>
                        </div>
                        <div class="nft-details bg-light bg-opacity-50 p-3 rounded-3 mb-3 border border-light">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small text-muted fw-bold">Area Size</span>
                                <span class="small fw-bold text-main">${land.area ? Number(land.area).toFixed(0) + ' m²' : 'N/A'}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted fw-bold">Floor Price</span>
                                <span class="fw-bold text-primary">🪙 ${Number(land.price).toLocaleString()}</span>
                            </div>
                        </div>
                        <a href="${land.checkout_url}" class="btn btn-primary w-100 fw-bold py-2 rounded-pill shadow-md hover-scale">
                            View Asset Details
                        </a>
                    </div>
                `;

                L.marker([land.lat, land.lng], { icon: customIcon })
                    .addTo(map)
                    .bindPopup(popupContent, {
                        closeButton: false,
                        offset: [0, -10],
                        className: 'premium-popup'
                    });
            });

            // Admin Direct Interaction
            @if(Auth::user()->is_admin)
                map.on('click', function (e) {
                    const lat = e.latlng.lat.toFixed(7);
                    const lng = e.latlng.lng.toFixed(7);

                    const adminPopup = L.popup()
                        .setLatLng(e.latlng)
                        .setContent(`
                                            <div class="text-center p-3 rounded-3 card-glass">
                                                <div class="small fw-bold text-primary mb-2 ls-1">ADMIN PANEL</div>
                                                <p class="x-small text-muted mb-3">Create new digital genesis at this coordinate?</p>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.lands.create') }}?lat=${lat}&lng=${lng}" 
                                                       class="btn btn-primary btn-sm fw-bold flex-grow-1 shadow-sm">
                                                        MINT HERE
                                                    </a>
                                                </div>
                                            </div>
                                        `)
                        .openOn(map);
                });
            @endif
        });
    </script>
    
    <style>
        .marker-container {
            position: relative;
            width: 24px;
            height: 24px;
        }
        .marker-pulse {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            opacity: 0.6;
            animation: pulse 2s infinite;
        }
        .marker-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        @keyframes pulse {
            0% { transform: translate(-50%, -50%) scale(0.5); opacity: 0.8; }
            100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
        }
        .leaflet-popup-content-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255,255,255,0.5);
        }
        .leaflet-popup-tip {
            background: rgba(255, 255, 255, 0.95);
        }
        [data-bs-theme="dark"] .leaflet-popup-content-wrapper {
            background: rgba(15, 23, 42, 0.95);
            color: #f8fafc;
            border: 1px solid rgba(255,255,255,0.1);
        }
        [data-bs-theme="dark"] .leaflet-popup-tip {
            background: rgba(15, 23, 42, 0.95);
        }
    </style>
</x-app-layout>