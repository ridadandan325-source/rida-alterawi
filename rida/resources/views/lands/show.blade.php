<x-app-layout>
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-end flex-wrap gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 rounded-pill px-3 py-2 fw-bold">
                    {{ $land->land_unique_id ?? $land->land_id ?? '—' }}
                </span>
                <span class="badge bg-{{ in_array($land->status, ['listed_admin','listed_owner']) ? 'warning' : 'success' }} bg-opacity-10 text-{{ in_array($land->status, ['listed_admin','listed_owner']) ? 'warning' : 'success' }} border border-{{ in_array($land->status, ['listed_admin','listed_owner']) ? 'warning' : 'success' }} border-opacity-20 rounded-pill px-3 py-2">
                    {{ str_replace('_', ' ', $land->status) }}
                </span>
            </div>
            <h1 class="page-title display-6 fw-bold mb-2 text-main font-serif">{{ $land->title }}</h1>
            <p class="page-subtitle mb-0">Digital land asset</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('map') }}" class="btn btn-glass rounded-pill px-4 fw-bold text-main hover-scale">
                <i class="fas fa-map me-2"></i> View on Map
            </a>
            @if(auth()->user()->is_admin ?? false)
            <a href="{{ route('admin.lands.edit', $land) }}" class="btn btn-primary rounded-pill px-4 fw-bold hover-scale">
                <i class="fas fa-cog me-2"></i> Admin Edit
            </a>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card card-ui border-0 shadow-sm overflow-hidden mb-4">
                <div class="card-body p-4">
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="p-4 rounded-3 card-ui border-0 h-100">
                                <div class="small text-muted text-uppercase fw-bold mb-2 ls-1">Valuation</div>
                                <div class="h4 fw-bold text-main font-serif mb-0">
                                    {{ number_format((float) $land->price, 2) }} <span class="text-muted fs-6">LNDC</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-3 card-ui border-0 h-100">
                                <div class="small text-muted text-uppercase fw-bold mb-2 ls-1">Owner</div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($land->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div class="fw-bold text-main">{{ $land->user->id === Auth::id() ? 'You' : ($land->user->name ?? '—') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold mb-3 text-main font-serif">Description</h5>
                        <div class="p-4 rounded-3 card-ui border-0 text-muted lh-lg">
                            {{ $land->description ?: 'Digital land asset with verified ownership.' }}
                        </div>
                    </div>

                    @can('buy', $land)
                    <div class="rounded-3 p-4 text-center text-white bg-gradient-primary">
                        <h5 class="fw-bold mb-2">Acquire this asset</h5>
                        <p class="small opacity-75 mb-3">Ownership transfers to your wallet on confirmation.</p>
                        <a href="{{ route('checkout.show', $land) }}" class="btn btn-light text-primary btn-lg rounded-pill px-4 fw-bold hover-scale">
                            Checkout <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                    @endcan
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-ui border-0 shadow-sm overflow-hidden mb-4">
                <div class="card-header d-flex align-items-center gap-3">
                    <div class="bg-gradient-primary rounded-3 p-2 text-white" style="width: 44px; height: 44px;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-main font-serif">Location</h6>
                        <p class="text-muted small mb-0">Coordinates</p>
                    </div>
                </div>
                <div class="card-body p-0 position-relative">
                    <div id="map" class="w-100" style="height: 280px;"></div>
                    <div class="p-3 border-top border-glass bg-body">
                        <div class="row g-2 small text-muted">
                            <div class="col-6"><span class="fw-bold ls-1">Lat</span> {{ $land->lat }}</div>
                            <div class="col-6"><span class="fw-bold ls-1">Lng</span> {{ $land->lng }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-ui border-0 shadow-sm overflow-hidden mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 text-main font-serif">Metadata</h6>
                    <ul class="list-unstyled mb-0 d-grid gap-2">
                        <li class="d-flex align-items-center justify-content-between p-3 rounded-3 card-ui border-0">
                            <span class="text-muted small fw-bold">Created</span>
                            <span class="fw-semibold text-main">{{ $land->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="d-flex align-items-center justify-content-between p-3 rounded-3 card-ui border-0">
                            <span class="text-muted small fw-bold">Updated</span>
                            <span class="fw-semibold text-main">{{ $land->updated_at->format('M d, Y') }}</span>
                        </li>
                        <li class="d-flex align-items-center justify-content-between p-3 rounded-3 card-ui border-0">
                            <span class="text-muted small fw-bold">Status</span>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 rounded-pill px-3">{{ str_replace('_', ' ', $land->status) }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            @if($land->ownerships()->count() > 0)
            <div class="card card-ui border-0 shadow-sm overflow-hidden">
                <div class="card-header">
                    <h6 class="fw-bold mb-0 text-main font-serif">Ownership History</h6>
                </div>
                        <div class="card-body p-4 pt-0">
                            <div class="timeline position-relative ps-3 border-start border-glass ms-2 mt-2">
                                @foreach($land->ownerships()->latest()->take(3)->get() as $ownership)
                                    <div class="position-relative ps-4 mb-4 last-mb-0">
                                        <div class="position-absolute top-0 start-0 translate-middle-x bg-body border border-2 border-primary rounded-circle shadow-sm" style="width:12px;height:12px;margin-top:6px;"></div>
                                        <div class="d-flex flex-column gap-1">
                                            <div class="small fw-bold text-primary">{{ $ownership->owned_at->format('M d, Y') }}</div>
                                            <div class="fw-semibold text-main">
                                                Transferred to <span class="text-primary">{{ $ownership->user->name }}</span>
                                            </div>
                                            <div class="small text-muted text-uppercase fw-bold ls-1">
                                                {{ $ownership->is_current ? 'Current Holder' : 'Previous Holder' }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
            @endif
        </div>
    </div>
    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('map', { zoomControl: false }).setView([{{ $land->lat }}, {{ $land->lng }}], 15);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                maxZoom: 20
            }).addTo(map);

            const customIcon = L.divIcon({
                className: '',
                html: `<div style="width:16px;height:16px;background:#4f46e5;border:3px solid white;border-radius:50%;box-shadow:0 0 15px rgba(79,70,229,0.5)"></div>`,
                iconSize: [16, 16],
                iconAnchor: [8, 8]
            });

            L.marker([{{ $land->lat }}, {{ $land->lng }}], { icon: customIcon }).addTo(map);
        });
    </script>
</x-app-layout>