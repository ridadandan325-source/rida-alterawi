<x-app-layout>
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
        <div>
            <h1 class="page-title display-6 fw-bold mb-2 text-gradient-primary">My Wallet</h1>
            <p class="page-subtitle mb-0">Manage balance and transaction history.</p>
        </div>
        <div class="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill card-ui border-glass">
            <span class="small text-muted fw-bold text-uppercase ls-1">Status</span>
            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 border border-success border-opacity-20">Active</span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm overflow-hidden rounded-3 text-white h-100" style="background: linear-gradient(135deg, var(--primary-dark), var(--primary));">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <span class="small text-white-50 text-uppercase fw-bold ls-1">Total Balance</span>
                            <h2 class="h3 fw-bold mb-0 mt-1 text-white">
                                <span class="opacity-75 me-1">🪙</span>{{ number_format((float) Auth::user()->wallet_balance, 2) }}
                            </h2>
                            <span class="badge bg-white bg-opacity-15 text-white border-0 mt-2">LNDC</span>
                        </div>
                        <div class="bg-white bg-opacity-10 rounded-3 p-2">
                            <i class="fas fa-wallet fs-4 text-white"></i>
                        </div>
                    </div>
                    <hr class="border-white border-opacity-15 my-3">
                    <form action="{{ route('wallet.topup') }}" method="POST">
                        @csrf
                        <label class="small text-white-50 mb-2 fw-bold text-uppercase ls-1">Quick Top-Up</label>
                        <div class="input-group bg-black bg-opacity-20 rounded-pill border border-white border-opacity-15 overflow-hidden">
                            <span class="input-group-text bg-transparent border-0 text-white-50 ps-3">🪙</span>
                            <input type="number" name="amount" class="form-control bg-transparent border-0 text-white fw-bold" value="500" min="10" max="10000" step="10" placeholder="Amount">
                            <button class="btn btn-light text-primary rounded-pill px-4 fw-bold" type="submit">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-ui border-0 shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0 text-main font-serif">Transaction History</h5>
                        <p class="text-muted small mb-0">Recent activity</p>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-ui align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Activity</th>
                                    <th>Asset</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $tx)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center w-40px h-40px {{ $tx->amount > 0 ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }}">
                                                <i class="fas fa-{{ $tx->amount > 0 ? 'arrow-down' : 'arrow-up' }}"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-main">{{ ucfirst($tx->type) }}</div>
                                                <div class="small text-muted line-clamp-1">{{ $tx->description }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($tx->land)
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 rounded-pill px-3 py-2">
                                                {{ $tx->land->land_unique_id ?? 'LAND' }}
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold {{ $tx->amount > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $tx->amount > 0 ? '+' : '' }}{{ number_format($tx->amount, 2) }} <small class="text-muted">LNDC</small>
                                        </span>
                                    </td>
                                    <td class="small text-muted">{{ $tx->created_at->format('M d, H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="py-4">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                                <i class="fas fa-receipt fa-2x text-primary"></i>
                                            </div>
                                            <p class="text-muted fw-bold mb-0">No transactions yet</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($transactions->hasPages())
                    <div class="p-3 border-top border-glass">
                        {{ $transactions->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
