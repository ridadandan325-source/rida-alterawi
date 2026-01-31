<x-app-layout>
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
        <div>
            <h1 class="page-title display-6 fw-bold mb-2 text-gradient-primary">My Properties</h1>
            <p class="page-subtitle mb-0">Manage your digital real estate portfolio.</p>
        </div>
        <div class="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill card-ui border-glass">
            <div class="bg-gradient-primary text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <span class="small text-muted fw-bold text-uppercase ls-1">Total</span>
                <span class="fw-bold text-main d-block">{{ $lands->count() }} Lands</span>
            </div>
        </div>
    </div>

    <div class="card card-ui border-0 overflow-hidden shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-gradient-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold text-main font-serif">Portfolio Overview</h5>
                    <p class="text-muted small mb-0">Your owned territories</p>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-ui align-middle mb-0">
                    <thead>
                                <tr>
                                    <th class="px-4 py-3 small fw-bold text-muted text-uppercase ls-1 border-0">Land ID</th>
                                    <th class="px-4 py-3 small fw-bold text-muted text-uppercase ls-1 border-0">Property Details</th>
                                    <th class="px-4 py-3 small fw-bold text-muted text-uppercase ls-1 border-0">Valuation</th>
                                    <th class="px-4 py-3 small fw-bold text-muted text-uppercase ls-1 border-0">Status</th>
                                    <th class="px-4 py-3 small fw-bold text-muted text-uppercase ls-1 border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lands as $land)
                                    <tr class="border-glass hover-bg-glass transition-colors group">
                                        <td class="px-4 py-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-light text-dark border border-secondary border-opacity-10 px-2 py-1 font-monospace">
                                                    #{{ $land->land_id ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-primary bg-opacity-10 rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-main font-serif">{{ $land->title }}</div>
                                                    @if($land->description)
                                                        <div class="small text-muted text-truncate line-clamp-1" style="max-width: 220px;">{{ Str::limit($land->description, 35) }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="fw-bold text-main font-serif">{{ number_format($land->price, 2) }} <span class="small text-muted fw-normal">LNDC</span></div>
                                            <div class="small text-muted">Market value</div>
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($land->status === 'listed_owner')
                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20 px-3 py-2 rounded-pill d-inline-flex align-items-center gap-2">
                                                    <span class="w-2 h-2 rounded-circle bg-warning animate-pulse"></span>
                                                    Listed for Sale
                                                </span>
                                            @else
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-3 py-2 rounded-pill d-inline-flex align-items-center gap-2">
                                                    <span class="w-2 h-2 rounded-circle bg-success"></span>
                                                    Securely Vaulted
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-end">
                                            <a href="{{ route('lands.show', $land) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                                View <i class="fas fa-arrow-right ms-1 small"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="py-4">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                                    <i class="fas fa-map-marked-alt fa-2x text-primary"></i>
                                                </div>
                                                <h5 class="fw-bold text-main font-serif mb-2">No lands yet</h5>
                                                <p class="text-muted small mb-4">Explore the map to acquire digital territories.</p>
                                                <a href="{{ route('map') }}" class="btn btn-primary rounded-pill px-4 hover-scale">Explore Map</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>