<x-app-layout>
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="page-title display-6 fw-bold mb-1 text-gradient-primary">Transaction History</h1>
            <p class="page-subtitle mb-0">System purchases and transfers.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-glass rounded-pill px-4 fw-bold text-main hover-scale">
            <i class="fas fa-arrow-left me-2"></i>Dashboard
        </a>
    </div>

    <div class="card card-ui border-0 overflow-hidden shadow-sm">
        <div class="card-header d-flex align-items-center gap-3">
            <div class="bg-gradient-primary rounded-3 p-2 text-white" style="width: 44px; height: 44px;">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold text-main font-serif">All Transactions</h5>
                <p class="text-muted small mb-0">Financial activity</p>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-ui align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Property</th>
                            <th>Buyer</th>
                            <th>Seller</th>
                            <th>Price</th>
                            <th class="text-end pe-4">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $p)
                        <tr>
                            <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-gradient-primary p-2 rounded-3 text-white d-flex align-items-center justify-content-center w-40px h-40px">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <span class="fw-bold text-main font-serif">{{ $p->land->title ?? 'Deleted' }}</span>
                            </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-main">{{ $p->buyer->name ?? '—' }}</div>
                                <div class="small text-muted fs-7">{{ $p->buyer->email ?? '' }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-main">{{ $p->seller->name ?? '—' }}</div>
                                <div class="small text-muted fs-7">{{ $p->seller->email ?? '' }}</div>
                            </td>
                            <td>
                                <span class="fw-bold text-success font-serif">{{ number_format((float)$p->price, 2) }} <span class="fs-7 text-muted">LNDC</span></span>
                            </td>
                            <td class="text-end pe-4 small text-muted">{{ $p->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-receipt fa-2x mb-3 opacity-50"></i>
                                <p class="fw-bold mb-0">No transactions yet</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer border-glass p-3 text-end">
            <small class="text-muted">Total: {{ $purchases->count() }}</small>
        </div>
    </div>
</x-app-layout>
