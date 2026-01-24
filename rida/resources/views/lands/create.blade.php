<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Land
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('lands.store') }}" class="space-y-4">
                    @csrf

                    {{-- Title --}}
                    <div>
                        <label class="block mb-1 font-semibold">Title</label>
                        <input name="title" value="{{ old('title') }}"
                               class="w-full border rounded p-2" required>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block mb-1 font-semibold">Description</label>
                        <textarea name="description" class="w-full border rounded p-2"
                                  rows="3">{{ old('description') }}</textarea>
                    </div>

                    {{-- Price --}}
                    <div>
                        <label class="block mb-1 font-semibold">Price</label>
                        <input name="price" type="number" step="0.01"
                               value="{{ old('price', 0) }}"
                               class="w-full border rounded p-2" required>
                    </div>

                    {{-- Map --}}
                    <div>
                        <label class="block mb-2 font-semibold">
                            Pick location on map (click)
                        </label>

                        <div id="map" style="height: 350px; border-radius: 12px;"></div>

                        <div class="grid grid-cols-2 gap-3 mt-3">
                            <div>
                                <label class="block mb-1">Lat</label>
                                <input id="lat" name="lat"
                                       value="{{ old('lat') }}"
                                       class="w-full border rounded p-2" required>
                            </div>

                            <div>
                                <label class="block mb-1">Lng</label>
                                <input id="lng" name="lng"
                                       value="{{ old('lng') }}"
                                       class="w-full border rounded p-2" required>
                            </div>
                        </div>
                    </div>

                    {{-- ✅ For Sale Checkbox (المطلوب) --}}
                    <div class="flex items-center gap-2 mt-2">
                        <input
                            type="checkbox"
                            name="is_for_sale"
                            value="1"
                            checked
                            class="rounded border-gray-300"
                        >
                        <label class="text-sm font-semibold">
                            For Sale (show on public map)
                        </label>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-2 pt-4">
                        <a href="{{ route('lands.index') }}"
                           class="px-4 py-2 border rounded">
                            Back
                        </a>

                        <button class="px-4 py-2 bg-black text-white rounded">
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([31.9539, 35.9106], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        let marker = null;

        map.on('click', function(e) {
            const lat = e.latlng.lat.toFixed(7);
            const lng = e.latlng.lng.toFixed(7);

            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;

            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng]).addTo(map);
        });
    </script>
</x-app-layout>
