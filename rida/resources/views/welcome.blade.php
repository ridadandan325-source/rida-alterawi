@php
    $lands = \App\Models\Land::where('is_for_sale', true)->latest()->take(3)->get();
@endphp

<x-app-layout>
    <div class="text-center py-5 mb-4 position-relative">
        <div class="position-absolute top-50 start-50 translate-middle w-75 h-75 rounded-circle bg-gradient-primary opacity-10 blur-3xl" style="z-index: 0;"></div>
        <div class="col-lg-9 mx-auto position-relative z-1">
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 rounded-pill px-3 py-2 mb-3 ls-1 fw-bold">Digital Real Estate</span>
            <h1 class="display-5 fw-bold mb-3 text-main font-serif lh-sm">
                Discover the <span class="text-gradient-primary">Digital World</span><br>
                <span class="text-muted fw-normal fs-4">of Exclusive Properties</span>
            </h1>
            <p class="lead text-muted mb-4 mx-auto" style="max-width: 36rem;">
                Secure, transparent ownership. Join a community of digital landowners.
            </p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="{{ route('map') }}" class="btn btn-primary px-4 py-2 rounded-pill hover-scale">
                    <i class="fas fa-map-marked-alt me-2"></i> Explore Map
                </a>
                <a href="{{ route('register') }}" class="btn btn-glass px-4 py-2 rounded-pill fw-bold text-main hover-scale">
                    Get Started
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card card-ui border-0 h-100 text-center hover-scale p-4">
                <div class="mb-3 text-primary opacity-75"><i class="fas fa-globe fa-2x"></i></div>
                <h3 class="h5 fw-bold text-main font-serif mb-2">Global Map</h3>
                <p class="text-muted small mb-0">Explore digital lands on an interconnected world map.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-ui border-0 h-100 text-center hover-scale p-4">
                <div class="mb-3 text-primary opacity-75"><i class="fas fa-lock fa-2x"></i></div>
                <h3 class="h5 fw-bold text-main font-serif mb-2">Secure Ownership</h3>
                <p class="text-muted small mb-0">Verified ownership and transparent transactions.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-ui border-0 h-100 text-center hover-scale p-4">
                <div class="mb-3 text-success opacity-75"><i class="fas fa-gem fa-2x"></i></div>
                <h3 class="h5 fw-bold text-main font-serif mb-2">Premium Assets</h3>
                <p class="text-muted small mb-0">High-value digital assets with clear market value.</p>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-gradient-primary rounded-3 p-2 text-white d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <h2 class="h5 fw-bold mb-0 text-main font-serif">Featured Properties</h2>
                    <p class="text-muted small mb-0">Hand-picked listings</p>
                </div>
            </div>
            <a href="{{ route('map') }}" class="btn btn-glass btn-sm px-3 rounded-pill fw-bold">View All <i class="fas fa-arrow-right ms-1 small"></i></a>
        </div>

        <div class="row g-4">
            @foreach($lands as $land)
            <div class="col-md-4">
                <div class="card card-ui border-0 h-100 overflow-hidden hover-scale">
                    <div class="bg-gradient-night d-flex align-items-center justify-content-center position-relative overflow-hidden" style="height: 180px;">
                        <div class="position-absolute w-100 h-100 opacity-20" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 16px 16px;"></div>
                        <i class="fas fa-map-marker-alt fa-3x text-white opacity-50 position-relative z-1"></i>
                        <span class="position-absolute top-0 end-0 m-3 badge bg-glass text-main border-glass rounded-pill px-3 py-2 fw-bold">
                            {{ number_format($land->price, 2) }} <small>LNDC</small>
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-main font-serif mb-2">{{ $land->title }}</h5>
                        <p class="card-text text-muted small line-clamp-2 mb-3">{{ $land->description ?? 'No description.' }}</p>
                        <a href="{{ route('checkout.show', $land) }}" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Acquire Asset</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
