<x-app-layout>
  <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="page-title display-6 fw-bold mb-1 text-gradient-primary">User Management</h1>
      <p class="page-subtitle mb-0">System users and permissions.</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-glass rounded-pill px-4 fw-bold text-main hover-scale">
      <i class="fas fa-arrow-left me-2"></i>Dashboard
    </a>
  </div>

  <div class="card card-ui border-0 overflow-hidden shadow-sm">
    <div class="card-header d-flex align-items-center gap-3">
      <div class="bg-gradient-primary rounded-3 p-2 text-white" style="width: 44px; height: 44px;">
        <i class="fas fa-users"></i>
      </div>
      <div>
        <h5 class="mb-0 fw-bold text-main font-serif">System Users</h5>
        <p class="text-muted small mb-0">Registered members</p>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-ui align-middle mb-0">
          <thead>
            <tr>
              <th class="ps-4">User</th>
              <th>Email</th>
              <th>Role</th>
              <th class="text-end pe-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $u)
            <tr>
              <td class="ps-4">
                <div class="d-flex align-items-center gap-3">
                  <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold bg-gradient-primary w-40px h-40px fs-6">
                    {{ strtoupper(substr($u->name, 0, 1)) }}
                  </div>
                  <span class="fw-semibold text-main">{{ $u->name }}</span>
                </div>
              </td>
              <td class="text-muted">{{ $u->email }}</td>
              <td>
                @if($u->is_admin)
                  <span class="badge bg-gradient-primary text-white px-3 py-2 rounded-pill">Admin</span>
                @else
                  <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-20 px-3 py-2 rounded-pill">User</span>
                @endif
              </td>
              <td class="text-end pe-4">
                <div class="d-flex justify-content-end gap-2">
                  <form method="POST" action="{{ route('admin.users.toggleAdmin', $u) }}" onsubmit="return confirm('Toggle admin role?');" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3" title="Toggle Admin"><i class="fas fa-user-shield"></i></button>
                  </form>
                  <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Delete this user?');" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-glass text-danger rounded-pill px-3" title="Delete"><i class="fas fa-trash-alt"></i></button>
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
