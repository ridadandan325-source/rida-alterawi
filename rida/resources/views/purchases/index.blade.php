<x-app-layout>
    <div class="page-header text-center mb-4">
        <h1 class="page-title display-6 fw-bold mb-2 text-gradient-primary">My Transactions</h1>
        <p class="page-subtitle mb-0 mx-auto" style="max-width: 32rem;">Purchases and sales history in one place.</p>
        <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
            <a href="{{ route('lands.index') }}" class="btn btn-glass rounded-pill px-3 fw-bold text-main hover-scale">
                <i class="fas fa-layer-group me-2"></i>My Lands
            </a>
            @if(Route::has('sales.index'))
            <a href="{{ route('sales.index') }}" class="btn btn-glass rounded-pill px-3 fw-bold text-main hover-scale">
                <i class="fas fa-coins me-2"></i>My Sales
            </a>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card card-ui border-0 shadow-sm h-100">
                <div class="card-header d-flex align-items-center gap-3">
                    <div class="bg-gradient-success rounded-3 p-2 text-white" style="width: 44px; height: 44px;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-main font-serif">My Purchases</h5>
                        <p class="text-muted small mb-0">Properties you acquired</p>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush border-0">
                        @forelse($buying as $purchase)
                        <div class="list-group-item border-glass border-0 p-4 hover-bg-glass">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success bg-opacity-10 p-2 rounded-3 text-success">
                                        <i class="fas fa-file-contract"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-main font-serif">{{ $purchase->land->title ?? 'Unknown' }}</div>
                                        <div class="small text-muted">{{ $purchase->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 rounded-pill px-3">Bought</span>
                            </div>
                            <div class="p-3 rounded-3 card-ui border-0 mb-2">
                                <div class="d-flex justify-content-between align-items-center small">
                                    <span class="text-muted">Price</span>
                                    <span class="fw-bold text-success">{{ number_format($purchase->price, 2) }} LNDC</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-glass small">
                                    <span class="text-muted">Seller</span>
                                    <span class="fw-semibold text-main">{{ $purchase->seller->name ?? '—' }}</span>
                                </div>
                            </div>
                            @if($purchase->land)
                            <a href="{{ route('map') }}" class="btn btn-sm btn-primary rounded-pill px-3">View on Map</a>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-5 px-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                <i class="fas fa-shopping-basket fa-2x text-primary"></i>
                            </div>
                            <p class="text-muted fw-bold mb-2">No purchases yet</p>
                            <a href="{{ route('map') }}" class="btn btn-primary rounded-pill px-4 hover-scale">Explore Map</a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-ui border-0 shadow-sm h-100">
                <div class="card-header d-flex align-items-center gap-3">
                    <div class="bg-gradient-accent rounded-3 p-2 text-white" style="width: 44px; height: 44px;">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-main font-serif">My Sales</h5>
                        <p class="text-muted small mb-0">Properties you sold</p>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush border-0">
                        @forelse($selling as $sale)
                        <div class="list-group-item border-glass border-0 p-4 hover-bg-glass">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-warning bg-opacity-10 p-2 rounded-3 text-warning">
                                        <i class="fas fa-handshake"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-main font-serif">{{ $sale->land->title ?? 'Unknown' }}</div>
                                        <div class="small text-muted">{{ $sale->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20 rounded-pill px-3">Sold</span>
                            </div>
                            <div class="p-3 rounded-3 card-ui border-0 mb-2">
                                <div class="d-flex justify-content-between align-items-center small">
                                    <span class="text-muted">Sold for</span>
                                    <span class="fw-bold text-warning">{{ number_format($sale->price, 2) }} LNDC</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-glass small">
                                    <span class="text-muted">Buyer</span>
                                    <span class="fw-semibold text-main">{{ $sale->buyer->name ?? '—' }}</span>
                                </div>
                            </div>
                            @if($sale->land)
                            <a href="{{ route('map') }}" class="btn btn-sm btn-glass rounded-pill px-3 fw-bold text-main hover-scale">View on Map</a>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-5 px-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                <i class="fas fa-piggy-bank fa-2x text-warning"></i>
                            </div>
                            <p class="text-muted fw-bold mb-0">No sales yet</p>
                            <p class="text-muted small mb-0">Sales will appear here</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
