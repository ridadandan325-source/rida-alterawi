<x-app-layout>
    <div class="position-relative overflow-hidden">
        {{-- Ambient Background Glows --}}
        <div class="position-absolute top-0 start-50 translate-middle-x pointer-events-none" style="z-index: 0;">
            <div class="bg-gradient-gold opacity-20 blur-3xl rounded-circle" style="width: 600px; height: 600px; transform: translate(20%, -20%);"></div>
            <div class="bg-gradient-primary opacity-20 blur-3xl rounded-circle" style="width: 500px; height: 500px; transform: translate(-20%, -10%);"></div>
        </div>

        <div class="position-relative" style="z-index: 1;">
            {{-- Header --}}
            <div class="mb-5 text-center">
                <span class="badge bg-white bg-opacity-20 border border-white border-opacity-20 text-white rounded-pill px-3 py-2 mb-3 backdrop-blur-sm shadow-sm">
                    <i class="fas fa-chart-line me-2"></i>Sales History
                </span>
                <h2 class="display-5 fw-bold mb-3 font-serif">
                    <span class="text-gradient-gold">Sold Properties</span>
                </h2>
                <p class="text-muted lead mx-auto" style="max-width: 600px;">
                    Track your real estate sales performance and transaction history.
                </p>
                
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="{{ route('lands.index') }}" class="btn btn-outline-light border-glass text-dark hover-scale">
                        <i class="fas fa-map me-2"></i>My Lands
                    </a>
                    @if(Route::has('purchases.index'))
                    <a href="{{ route('purchases.index') }}" class="btn btn-primary border-glass hover-scale">
                        <i class="fas fa-shopping-bag me-2"></i>My Purchases
                    </a>
                    @endif
                </div>
            </div>

            {{-- Sales Content --}}
            @if($sales->count() === 0)
                <div class="card card-glass border-0 shadow-2xl p-5 text-center mx-auto" style="max-width: 500px; border-radius: 24px;">
                    <div class="mb-4">
                        <div class="bg-gradient-gold p-4 rounded-circle d-inline-flex text-white shadow-lg animate-float">
                            <i class="fas fa-file-invoice-dollar fs-1"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-2 font-serif">No Sales Yet</h4>
                    <p class="text-muted mb-4">You haven't sold any properties yet. List your lands to start earning.</p>
                    <a href="{{ route('lands.index') }}" class="btn btn-primary hover-scale">
                        View My Lands
                    </a>
                </div>
            @else
                <div class="row g-4">
                    @foreach($sales as $sale)
                        <div class="col-md-6 col-xl-4">
                            <div class="card card-glass border-0 h-100 hover-lift overflow-hidden" style="border-radius: 20px;">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-success bg-opacity-10 p-3 rounded-2xl text-success">
                                                <i class="fas fa-check-circle fs-4"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-1 font-serif text-truncate" style="max-width: 200px;">
                                                    {{ $sale->land->title ?? 'Deleted land' }}
                                                </h5>
                                                <p class="small text-muted mb-0">
                                                    {{ $sale->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="badge bg-success bg-opacity-20 text-success border border-success border-opacity-20 rounded-pill px-3 py-2">
                                            Sold
                                        </span>
                                    </div>

                                    <div class="p-3 rounded-2xl bg-white bg-opacity-50 border border-white border-opacity-50 mb-4">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="small text-muted mb-1">Sale Price</div>
                                                <div class="fw-bold text-success fs-5">
                                                    {{ number_format((float)$sale->price, 2) }} <span class="fs-7">JOD</span>
                                                </div>
                                            </div>
                                            <div class="col-6 border-start border-secondary border-opacity-10 ps-3">
                                                <div class="small text-muted mb-1">Buyer</div>
                                                <div class="fw-semibold text-truncate">
                                                    {{ $sale->buyer->name ?? 'Unknown' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="small text-muted">
                                            <i class="fas fa-envelope me-1"></i> 
                                            {{ Str::limit($sale->buyer->email ?? '', 20) }}
                                        </div>
                                        @if($sale->land)
                                            <a href="{{ url('/map?land_id='.$sale->land->id) }}" class="btn btn-sm btn-outline-primary border-glass hover-scale rounded-pill px-3">
                                                <i class="fas fa-map-marker-alt me-1"></i> Locate
                                            </a>
                                        @else
                                            <button disabled class="btn btn-sm btn-secondary rounded-pill px-3 opacity-50">
                                                Removed
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
