<x-app-layout>
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="page-title display-6 fw-bold mb-2 text-gradient-primary">Dashboard</h1>
            <p class="page-subtitle mb-0">Welcome back, <span class="fw-bold text-main">{{ Auth::user()->name }}</span> — manage your digital assets.</p>
        </div>
        <div class="d-flex gap-2 flex-shrink-0">
            <a href="{{ route('map') }}" class="btn btn-primary px-4 d-flex align-items-center gap-2 hover-scale">
                <i class="fas fa-map-marked-alt"></i> Map
            </a>
            <a href="{{ route('wallet.index') }}" class="btn btn-glass px-4 d-flex align-items-center gap-2 fw-bold text-main hover-scale">
                <i class="fas fa-wallet text-primary"></i> Wallet
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden rounded-3 text-white" style="background: linear-gradient(135deg, var(--primary-dark), var(--primary));">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="small text-white-50 text-uppercase fw-bold ls-1">Balance</span>
                            <h2 class="h3 fw-bold mb-0 mt-1 text-white">
                                <span class="opacity-75 me-1">🪙</span>{{ number_format((float) $walletBalance, 2) }}
                            </h2>
                            <span class="badge bg-white bg-opacity-15 text-white border-0 mt-2">LNDC</span>
                        </div>
                        <div class="bg-white bg-opacity-10 rounded-3 p-2">
                            <i class="fas fa-wallet fs-4 text-white"></i>
                        </div>
                    </div>
                    <a href="{{ route('wallet.index') }}" class="btn btn-sm btn-light text-primary w-100 mt-4 fw-bold rounded-pill">
                        Manage Wallet <i class="fas fa-arrow-right ms-1 small"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row g-4 h-100">
                <div class="col-md-4">
                    <div class="card card-ui border-0 h-100 hover-scale text-center">
                        <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                            <div class="mb-3 rounded-circle d-inline-flex align-items-center justify-content-center w-56px h-56px bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-mountain fs-4"></i>
                            </div>
                            <h3 class="h4 fw-bold mb-0 text-main">{{ $totalLands }}</h3>
                            <span class="small text-muted text-uppercase fw-bold ls-1 mt-1">Owned Lands</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-ui border-0 h-100 hover-scale text-center">
                        <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                            <div class="mb-3 rounded-circle d-inline-flex align-items-center justify-content-center w-56px h-56px bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-shopping-cart fs-4"></i>
                            </div>
                            <h3 class="h4 fw-bold mb-0 text-main">{{ $purchasesCount }}</h3>
                            <span class="small text-muted text-uppercase fw-bold ls-1 mt-1">Purchases</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-ui border-0 h-100 hover-scale text-center">
                        <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                            <div class="mb-3 rounded-circle d-inline-flex align-items-center justify-content-center w-56px h-56px bg-success bg-opacity-10 text-success">
                                <i class="fas fa-coins fs-4"></i>
                            </div>
                            <h3 class="h4 fw-bold mb-0 text-main">{{ $salesCount }}</h3>
                            <span class="small text-muted text-uppercase fw-bold ls-1 mt-1">Sales</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="card card-ui border-0 overflow-hidden shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-primary rounded-3 p-2 text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-history"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-main font-serif">Recent Activity</h5>
                    </div>
                    <a href="{{ route('wallet.index') }}" class="btn btn-sm btn-glass px-3 rounded-pill fw-bold">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-ui align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Type</th>
                                    <th>Asset</th>
                                    <th>Amount</th>
                                    <th>Time</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestTransactions as $tx)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill small fw-bold {{ $tx->amount > 0 ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }}">
                                                <i class="fas {{ $tx->amount > 0 ? 'fa-arrow-down' : 'fa-arrow-up' }} small"></i>
                                                {{ strtoupper($tx->type) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($tx->land)
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded bg-light bg-opacity-50 p-1 border border-secondary border-opacity-10">
                                                        <i class="fas fa-map-marker-alt text-muted small"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-main small">{{ $tx->land->land_unique_id ?? $tx->land->title }}</div>
                                                        <div class="text-muted fs-7">{{ $tx->land->land_unique_id ?? ($tx->land->title ?? '—') }}</div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted fst-italic">System Transaction</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="fw-bold {{ $tx->amount > 0 ? 'text-success' : 'text-main' }}">
                                                {{ $tx->amount > 0 ? '+' : '' }} {{ number_format((float) $tx->amount, 2) }} <small class="text-muted">LNDC</small>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-muted small">
                                            {{ $tx->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-4 py-3 text-end pe-4">
                                            @if($tx->land)
                                                <a href="{{ route('lands.show', $tx->land) }}"
                                                    class="btn btn-sm btn-glass rounded-pill px-3 shadow-sm hover-scale">
                                                    View Asset
                                                </a>
                                            @else
                                                <span class="badge bg-light text-muted border">Completed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center justify-content-center text-muted opacity-50">
                                                <i class="fas fa-receipt display-4 mb-3"></i>
                                                <p class="mb-0">No recent transactions found.</p>
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