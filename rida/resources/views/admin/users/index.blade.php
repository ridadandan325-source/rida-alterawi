<x-app-layout>
  <x-slot name="header">
    <div class="flex items-start justify-between gap-4">
      <div>
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">Admin • Users</h2>
        <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">Manage users and admin roles.</p>
      </div>
      <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center rounded-2xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold hover:bg-gray-50 dark:bg-white/5 dark:border-white/10 dark:text-white dark:hover:bg-white/10">
        Admin Dashboard
      </a>
    </div>
  </x-slot>

  <div class="rounded-3xl border border-gray-200 bg-white shadow-sm dark:bg-white/5 dark:border-white/10 overflow-hidden">
    <div class="p-6">
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="border-b border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-200">
              <th class="py-2 pr-4">Name</th>
              <th class="py-2 pr-4">Email</th>
              <th class="py-2 pr-4">Role</th>
              <th class="py-2 pr-4">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $u)
              <tr class="border-b border-gray-100 dark:border-white/5">
                <td class="py-3 pr-4 font-semibold text-gray-900 dark:text-white">{{ $u->name }}</td>
                <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ $u->email }}</td>
                <td class="py-3 pr-4">
                  @if($u->is_admin)
                    <span class="px-2 py-1 text-xs rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-200">Admin</span>
                  @else
                    <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700 dark:bg-white/10 dark:text-gray-200">User</span>
                  @endif
                </td>
                <td class="py-3 pr-4">
                  <form method="POST" action="{{ route('admin.users.toggleAdmin', $u) }}"
                        onsubmit="return confirm('Toggle admin role for this user?')">
                    @csrf
                    @method('PATCH')
                    <button class="inline-flex items-center rounded-xl bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:opacity-90">
                      Toggle Admin
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</x-app-layout>
