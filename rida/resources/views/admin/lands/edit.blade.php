<x-app-layout>
    <div class="position-relative overflow-hidden">
        {{-- Ambient Background Glows --}}
        <div class="position-absolute top-0 start-50 translate-middle-x pointer-events-none" style="z-index: 0;">
            <div class="bg-gradient-teal opacity-20 blur-3xl rounded-circle" style="width: 600px; height: 600px; transform: translate(-30%, -20%);"></div>
            <div class="bg-gradient-cyan opacity-20 blur-3xl rounded-circle" style="width: 500px; height: 500px; transform: translate(30%, -10%);"></div>
        </div>

        <div class="position-relative" style="z-index: 1;">
            <div class="mb-5 d-flex justify-content-between align-items-end">
                <div>
                    <span class="badge bg-white bg-opacity-20 border border-white border-opacity-20 text-white rounded-pill px-3 py-2 mb-3 backdrop-blur-sm shadow-sm">
                        <i class="fas fa-shield-alt me-2"></i>Administration
                    </span>
                    <h2 class="display-6 fw-bold mb-2 font-serif">
                        <span class="text-gradient-teal">Edit Property</span>
                    </h2>
                    <p class="text-muted lead mb-0">Update land details and location.</p>
                </div>
                <a href="{{ route('admin.lands.index') }}" class="btn btn-outline-light border-glass text-dark hover-scale">
                    <i class="bi bi-arrow-left me-1"></i>Back to List
                </a>
            </div>

            <div class="card card-glass border-0 shadow-2xl overflow-hidden" style="border-radius: 24px;">
                <div class="card-header border-glass bg-transparent p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-teal p-3 rounded-2xl text-white shadow-sm">
                            <i class="fas fa-edit fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-dark font-serif fs-5">Edit Property Details</h6>
                            <p class="text-muted small mb-0">Modifying: {{ $land->title }}</p>
                        </div>
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

                    <form method="POST" action="{{ route('admin.lands.update', $land) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-4 mb-4">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase ls-1 text-muted">Title</label>
                                <input name="title" value="{{ old('title', $land->title) }}" class="form-control form-control-lg bg-glass-lighter border-glass shadow-none fw-semibold" required>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase ls-1 text-muted">Description</label>
                                <textarea name="description" rows="4" class="form-control bg-glass-lighter border-glass shadow-none">{{ old('description', $land->description) }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-1 text-muted">Price (JOD)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-glass-lighter border-glass text-muted">JOD</span>
                                    <input name="price" type="number" step="0.01" value="{{ old('price', $land->price) }}" class="form-control form-control-lg bg-glass-lighter border-glass shadow-none fw-bold text-teal" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-1 text-muted">Owner</label>
                                <select name="user_id" class="form-select form-select-lg bg-glass-lighter border-glass shadow-none">
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}" {{ (int) old('user_id', $land->user_id) === (int) $u->id ? 'selected' : '' }}>
                                            {{ $u->name }} ({{ $u->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-1 text-muted">Latitude</label>
                                <input id="lat" name="lat" value="{{ old('lat', $land->lat) }}" class="form-control bg-glass-lighter border-glass shadow-none" readonly required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-1 text-muted">Longitude</label>
                                <input id="lng" name="lng" value="{{ old('lng', $land->lng) }}" class="form-control bg-glass-lighter border-glass shadow-none" readonly required>
                            </div>
                        </div>

                        {{-- Map --}}
                        <div class="mb-5">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="icon-wrapper w-32px h-32px bg-gradient-cyan text-white fs-6 rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                                <div>
                                    <label class="form-label fw-bold mb-0">Location Editor</label>
                                    <p class="text-muted small mb-0">Click on the map to update the property location</p>
                                </div>
                            </div>
                            <div id="map" class="rounded-4 shadow-lg border-glass" style="height: 400px; z-index: 1;"></div>
                        </div>

                        <div class="form-check form-switch mb-5">
                            <input type="checkbox" name="is_for_sale" value="1" {{ old('is_for_sale', $land->is_for_sale) ? 'checked' : '' }} class="form-check-input" id="is_for_sale" style="width: 3em; height: 1.5em;">
                            <label class="form-check-label fw-bold ms-2 pt-1" for="is_for_sale">
                                List for Sale
                            </label>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.lands.index') }}" class="btn btn-light border-glass px-4 py-2 fw-bold rounded-pill hover-scale">Cancel</a>
                            <button type="submit" class="btn btn-primary bg-gradient-teal border-0 px-5 py-2 fw-bold rounded-pill shadow-lg hover-scale">
                                <i class="fas fa-save me-2"></i>Save Changes
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
        const initialLat = {{ $land->lat ?? 31.9539 }};
        const initialLng = {{ $land->lng ?? 35.9106 }};

        const map = L.map('map', {
            zoomControl: false
        }).setView([initialLat, initialLng], 14);
        
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