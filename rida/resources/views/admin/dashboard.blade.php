<x-app-layout>
  <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="page-title display-6 fw-bold mb-1 text-gradient-primary">Admin Dashboard</h1>
      <p class="page-subtitle mb-0">System overview and activity.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('admin.lands.index') }}" class="btn btn-primary rounded-pill px-4 fw-bold hover-scale">
        <i class="fas fa-map-marked-alt me-2"></i>Lands
      </a>
      <a href="{{ route('admin.users.index') }}" class="btn btn-glass rounded-pill px-4 fw-bold text-main hover-scale">
        <i class="fas fa-users me-2"></i>Users
      </a>
      <a href="{{ route('admin.purchases.index') }}" class="btn btn-glass rounded-pill px-4 fw-bold text-main hover-scale">
        <i class="fas fa-shopping-cart me-2"></i>Purchases
      </a>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card card-ui border-0 h-100 hover-scale">
        <div class="card-body p-4">
          <div class="small text-muted text-uppercase fw-bold ls-1 mb-2">Users</div>
          <div class="h4 mb-0 fw-bold text-main font-serif">{{ $usersCount }}</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card card-ui border-0 h-100 hover-scale">
        <div class="card-body p-4">
          <div class="small text-muted text-uppercase fw-bold ls-1 mb-2">Lands</div>
          <div class="h4 mb-0 fw-bold text-main font-serif">{{ $landsCount }}</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card card-ui border-0 h-100 hover-scale">
        <div class="card-body p-4">
          <div class="small text-muted text-uppercase fw-bold ls-1 mb-2">For Sale</div>
          <div class="h4 mb-0 fw-bold text-main font-serif">{{ $forSaleCount }}</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card card-ui border-0 h-100 hover-scale">
        <div class="card-body p-4">
          <div class="small text-muted text-uppercase fw-bold ls-1 mb-2">Sold</div>
          <div class="h4 mb-0 fw-bold text-main font-serif">{{ $soldCount }}</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card card-ui border-0 h-100 hover-scale">
        <div class="card-body p-4">
          <div class="small text-muted text-uppercase fw-bold ls-1 mb-2">Purchases</div>
          <div class="h4 mb-0 fw-bold text-main font-serif">{{ $purchasesCount }}</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card card-ui border-0 h-100 hover-scale">
        <div class="card-body p-4">
          <div class="small text-muted text-uppercase fw-bold ls-1 mb-2">Volume</div>
          <div class="h4 mb-0 fw-bold text-main font-serif text-truncate">{{ number_format((float) $totalVolume, 0) }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="card card-ui border-0 overflow-hidden shadow-sm">
    <div class="card-header d-flex align-items-center gap-3">
      <div class="bg-gradient-primary rounded-3 p-2 text-white" style="width: 44px; height: 44px;">
        <i class="fas fa-chart-line"></i>
      </div>
      <div>
        <h5 class="mb-0 fw-bold text-main font-serif">Latest Transactions</h5>
        <p class="text-muted small mb-0">Purchase activity</p>
      </div>
    </div>
    <div class="card-body p-4">
      @forelse($latestPurchases as $p)
        <div class="rounded-3 p-4 mb-3 card-ui border-0 hover-bg-glass">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
              <div class="bg-success bg-opacity-10 p-2 rounded-3 text-success">
                <i class="fas fa-file-contract"></i>
              </div>
              <div>
                <div class="fw-bold text-main font-serif mb-1">{{ $p->land->title ?? 'Deleted' }}</div>
                <div class="small text-muted">
                  {{ $p->buyer->name ?? '—' }} ← {{ $p->seller->name ?? '—' }} · {{ $p->created_at->format('M d, Y') }}
                </div>
              </div>
            </div>
            <div class="text-end">
              <div class="fw-bold text-primary font-serif">{{ number_format((float) $p->price, 2) }} <span class="fs-7 text-muted">LNDC</span></div>
              <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 mt-1">Done</span>
            </div>
          </div>
        </div>
      @empty
        <div class="text-center py-5 text-muted">
          <i class="fas fa-inbox fa-2x mb-3 opacity-50"></i>
          <p class="fw-bold mb-0">No purchases yet</p>
        </div>
      @endforelse
    </div>
  </div>
</x-app-layout>