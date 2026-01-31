<x-app-layout>
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="page-title display-6 fw-bold mb-1 text-gradient-primary">Add Land</h1>
            <p class="page-subtitle mb-0">Create a new land listing.</p>
        </div>
        <a href="{{ route('admin.lands.index') }}" class="btn btn-glass rounded-pill px-4 fw-bold text-main hover-scale">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="card card-ui border-0 shadow-sm overflow-hidden">
        <div class="card-header d-flex align-items-center gap-3">
            <div class="bg-gradient-primary rounded-3 p-2 text-white" style="width: 44px; height: 44px;">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold text-main font-serif">Property Details</h5>
                <p class="text-muted small mb-0">Fill in the form below</p>
            </div>
        </div>
                
                <div class="card-body p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-20 text-danger rounded-4 mb-4">
                            <ul class="mb-0 small fw-bold">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.lands.store') }}">
                        @csrf

                        <div class="row g-4 mb-4">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase ls-1 text-muted">Title</label>
                                <input name="title" value="{{ old('title') }}" class="form-control form-control-lg bg-glass-lighter border-glass shadow-none fw-semibold" placeholder="e.g. Luxury Villa in Amman" required>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase ls-1 text-muted">Description</label>
                                <textarea name="description" rows="4" class="form-control bg-glass-lighter border-glass shadow-none" placeholder="Detailed property description...">{{ old('description') }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-1 text-muted">Price (JOD)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-glass-lighter border-glass text-muted">JOD</span>
                                    <input name="price" type="number" step="0.01" value="{{ old('price', 0) }}" class="form-control form-control-lg bg-glass-lighter border-glass shadow-none fw-bold text-teal" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-1 text-muted">Owner</label>
                                <select name="user_id" class="form-select form-select-lg bg-glass-lighter border-glass shadow-none">
                                    <option value="" disabled selected>Select an owner...</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}" {{ (int) old('user_id') === (int) $u->id ? 'selected' : '' }}>
                                            {{ $u->name }} ({{ $u->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-1 text-muted">Latitude</label>
                                <input id="lat" name="lat" value="{{ old('lat', request('lat', '31.9539')) }}" class="form-control bg-glass-lighter border-glass shadow-none" readonly required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-1 text-muted">Longitude</label>
                                <input id="lng" name="lng" value="{{ old('lng', request('lng', '35.9106')) }}" class="form-control bg-glass-lighter border-glass shadow-none" readonly required>
                            </div>
                        </div>

                        {{-- Map --}}
                        <div class="mb-5">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="icon-wrapper w-32px h-32px bg-gradient-cyan text-white fs-6 rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                                <div>
                                    <label class="form-label fw-bold mb-0">Location Selector</label>
                                    <p class="text-muted small mb-0">Click on the map to pin the exact location</p>
                                </div>
                            </div>
                            <div id="map" class="rounded-4 shadow-lg border-glass" style="height: 400px; z-index: 1;"></div>
                        </div>

                        <div class="form-check form-switch mb-5">
                            <input type="checkbox" name="is_for_sale" value="1" {{ old('is_for_sale', true) ? 'checked' : '' }} class="form-check-input" id="is_for_sale" style="width: 3em; height: 1.5em;">
                            <label class="form-check-label fw-bold ms-2 pt-1" for="is_for_sale">
                                List for Sale Immediately
                            </label>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.lands.index') }}" class="btn btn-light border-glass px-4 py-2 fw-bold rounded-pill hover-scale">Cancel</a>
                            <button type="submit" class="btn btn-primary bg-gradient-teal border-0 px-5 py-2 fw-bold rounded-pill shadow-lg hover-scale">
                                <i class="fas fa-check-circle me-2"></i>Create Property
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const initialLat = document.getElementById('lat').value || 31.9539;
        const initialLng = document.getElementById('lng').value || 35.9106;

        const map = L.map('map', {
            zoomControl: false
        }).setView([initialLat, initialLng], 12);
        
        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
        }).addTo(map);

        let marker = L.marker([initialLat, initialLng]).addTo(map);

        map.on('click', function (e) {
            const lat = e.latlng.lat.toFixed(7);
            const lng = e.latlng.lng.toFixed(7);

            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;

            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng]).addTo(map);
        });
    </script>
</x-app-layout>