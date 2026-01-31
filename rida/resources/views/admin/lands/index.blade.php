<x-app-layout>
  <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="page-title display-6 fw-bold mb-1 text-gradient-primary">Land Management</h1>
      <p class="page-subtitle mb-0">All digital territories.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.lands.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold hover-scale">
        <i class="fas fa-plus me-2"></i>Add Land
      </a>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-glass rounded-pill px-4 fw-bold text-main hover-scale">
        <i class="fas fa-arrow-left me-2"></i>Dashboard
      </a>
    </div>
  </div>

  <div class="card card-ui border-0 overflow-hidden shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div class="d-flex align-items-center gap-3">
        <div class="bg-gradient-primary rounded-3 p-2 text-white" style="width: 44px; height: 44px;">
          <i class="fas fa-layer-group"></i>
        </div>
        <div>
          <h5 class="mb-0 fw-bold text-main font-serif">All Properties</h5>
          <p class="text-muted small mb-0">Registry of lands</p>
        </div>
      </div>
      <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 rounded-pill px-3 py-2 fw-bold">{{ $lands->count() }}</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-ui align-middle mb-0">
          <thead>
            <tr>
              <th class="ps-4">Title</th>
              <th>Owner</th>
              <th>Price</th>
              <th>Status</th>
              <th class="text-end pe-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($lands as $land)
            <tr>
              <td class="ps-4">
                <div class="d-flex align-items-center gap-3">
                  <div class="bg-primary bg-opacity-10 rounded-3 p-2 text-primary" style="width: 40px; height: 40px;">
                    <i class="fas fa-map-marker-alt"></i>
                  </div>
                  <span class="fw-bold text-main font-serif">{{ $land->title }}</span>
                </div>
              </td>
              <td>
                <div class="fw-bold text-main">{{ $land->user->name ?? '—' }}</div>
                <div class="small text-muted fs-7">{{ $land->user->email ?? '' }}</div>
              </td>
              <td>
                <span class="fw-bold text-primary font-serif">{{ number_format((float) $land->price, 2) }} <span class="small text-muted">LNDC</span></span>
              </td>
              <td>
                @if($land->is_for_sale)
                  <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 rounded-pill px-3 py-2">For Sale</span>
                @else
                  <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-20 rounded-pill px-3 py-2">Not Listed</span>
                @endif
              </td>
              <td class="text-end pe-4">
                <div class="d-flex gap-2 justify-content-end">
                  <a class="btn btn-sm btn-primary rounded-pill px-3" href="{{ route('admin.lands.edit', $land) }}">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form method="POST" action="{{ route('admin.lands.destroy', $land) }}" onsubmit="return confirm('Delete this land?');" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-glass text-danger rounded-pill px-3">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</x-app-layout>