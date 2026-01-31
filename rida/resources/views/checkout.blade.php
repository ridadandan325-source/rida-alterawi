<x-app-layout>
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 rounded-pill px-3 py-2 mb-2 ls-1 fw-bold">
                <i class="fas fa-lock me-2"></i>Secure Transaction
            </span>
            <h1 class="page-title display-6 fw-bold mb-1 text-gradient-primary">Checkout</h1>
            <p class="page-subtitle mb-0">Complete your acquisition of this digital asset.</p>
        </div>
        <a href="{{ route('map') }}" class="btn btn-glass rounded-pill px-4 fw-bold text-main hover-scale">
            <i class="fas fa-arrow-left me-2"></i>Back to Map
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card card-ui border-0 shadow-sm h-100">
                <div class="card-header d-flex align-items-center gap-3">
                    <div class="bg-gradient-primary rounded-3 p-2 text-white" style="width: 44px; height: 44px;">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-main font-serif">Order Summary</h5>
                        <p class="text-muted small mb-0">Asset details</p>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center p-4 rounded-3 bg-gradient-primary text-white mb-3">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                        </div>
                        <h4 class="fw-bold text-main font-serif mb-2">{{ $land->title }}</h4>
                        <p class="text-muted small mb-0">{{ $land->description ?? 'No description.' }}</p>
                    </div>
                    <div class="rounded-3 p-4 mb-4 bg-gradient-primary text-white">
                        <div class="small opacity-75 text-uppercase fw-bold ls-1 mb-1">Total Price</div>
                        <div class="h4 fw-bold mb-0 font-serif">
                            {{ number_format((float) $land->price, 2) }} <span class="fs-6 opacity-75">LNDC</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 small text-muted justify-content-center">
                        <i class="fas fa-shield-alt text-success"></i>
                        <span>Secure transaction</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-ui border-0 shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-accent rounded-3 p-2 text-white" style="width: 44px; height: 44px;">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-main font-serif">Payment</h5>
                            <p class="text-muted small mb-0">Wallet balance</p>
                        </div>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 rounded-pill px-3 py-2">
                        <i class="fas fa-lock me-1"></i> Secure
                    </span>
                </div>
                <div class="card-body p-4">
                    @php
                        $balance = Auth::user()->wallet_balance;
                        $price = $land->price;
                        $canAfford = $balance >= $price;
                        $remaining = $balance - $price;
                    @endphp

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="p-4 rounded-3 card-ui border-0 h-100">
                                <div class="small text-muted text-uppercase fw-bold ls-1 mb-2">Current Balance</div>
                                <div class="h4 fw-bold mb-0 text-main font-serif">
                                    <span class="text-muted me-1">🪙</span>{{ number_format($balance, 2) }} <span class="fs-6 text-muted">LNDC</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-3 h-100 {{ $canAfford ? 'bg-success bg-opacity-10' : 'bg-danger bg-opacity-10' }}">
                                <div class="small {{ $canAfford ? 'text-success' : 'text-danger' }} text-uppercase fw-bold ls-1 mb-2">After Purchase</div>
                                <div class="h4 fw-bold mb-0 {{ $canAfford ? 'text-success' : 'text-danger' }} font-serif">
                                    <span class="opacity-75 me-1">🪙</span>{{ number_format($remaining, 2) }} <span class="fs-6 opacity-75">LNDC</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!$canAfford)
                        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 p-4 mb-4 d-flex align-items-center gap-3">
                            <div class="bg-danger bg-opacity-20 p-2 rounded-circle">
                                <i class="fas fa-exclamation-triangle fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold font-serif">Insufficient funds</div>
                                <div class="small opacity-90">You need <b>{{ number_format(abs($remaining), 2) }} LNDC</b> more.</div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('wallet.index') }}" class="btn btn-primary rounded-pill px-4 fw-bold hover-scale">
                                <i class="fas fa-plus-circle me-2"></i> Top Up Wallet
                            </a>
                            <a href="{{ route('map') }}" class="btn btn-glass rounded-pill px-4 fw-bold text-main hover-scale">Cancel</a>
                        </div>
                    @else
                        <form id="payForm" method="POST" action="{{ route('checkout.pay', $land) }}">
                            @csrf
                            <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-3 p-4 mb-4 d-flex align-items-center gap-3">
                                <div class="bg-success bg-opacity-20 p-2 rounded-circle">
                                    <i class="fas fa-check-circle fs-4"></i>
                                </div>
                                <div>
                                    <div class="fw-bold font-serif">Ready to purchase</div>
                                    <div class="small opacity-90">Ownership transfers on confirmation.</div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <button id="payBtn" type="submit" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold hover-scale">
                                    Confirm Purchase <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                                <a href="{{ route('map') }}" class="btn btn-link text-muted text-decoration-none">Cancel</a>
                            </div>
                            <div id="processing" class="d-none mt-4 p-3 rounded-3 card-ui">
                                <div class="d-flex align-items-center gap-3 text-muted">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                    <span class="small fw-bold">Processing...</span>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($canAfford ?? false)
    <script>
        (function() {
            const form = document.getElementById('payForm');
            const btn = document.getElementById('payBtn');
            const processing = document.getElementById('processing');
            if (form && btn && processing) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-lock me-2"></i> Securing...';
                    btn.classList.add('opacity-75');
                    processing.classList.remove('d-none');
                    setTimeout(function() { form.submit(); }, 1200);
                });
            }
        })();
    </script>
    @endif
</x-app-layout>
