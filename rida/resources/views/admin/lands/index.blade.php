<x-app-layout>
  <x-slot name="header">
    <div class="flex items-start justify-between gap-4">
      <div>
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">Admin • Lands</h2>
        <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">Manage all lands.</p>
      </div>
      <div class="flex gap-2">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center rounded-2xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold hover:bg-gray-50 dark:bg-white/5 dark:border-white/10 dark:text-white dark:hover:bg-white/10">Admin Dashboard</a>
      </div>
    </div>
  </x-slot>

  <div class="rounded-3xl border border-gray-200 bg-white shadow-sm dark:bg-white/5 dark:border-white/10 overflow-hidden">
    <div class="p-6">
      <div class="text-sm text-gray-500 dark:text-gray-300 mb-4">Total: <b>{{ $lands->count() }}</b></div>

      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="border-b border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-200">
              <th class="py-2 pr-4">Title</th>
              <th class="py-2 pr-4">Owner</th>
              <th class="py-2 pr-4">Price</th>
              <th class="py-2 pr-4">For Sale</th>
              <th class="py-2 pr-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($lands as $land)
              <tr class="border-b border-gray-100 dark:border-white/5">
                <td class="py-3 pr-4 font-semibold text-gray-900 dark:text-white">{{ $land->title }}</td>
                <td class="py-3 pr-4 text-sm text-gray-600 dark:text-gray-300">
                  {{ $land->user->name ?? 'Unknown' }}
                  <div class="text-xs text-gray-500 dark:text-gray-400">{{ $land->user->email ?? '' }}</div>
                </td>
                <td class="py-3 pr-4 text-gray-900 dark:text-white">{{ number_format((float)$land->price, 2) }}</td>
                <td class="py-3 pr-4">
                  @if($land->is_for_sale)
                    <span class="px-2 py-1 text-xs rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-200">Yes</span>
                  @else
                    <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700 dark:bg-white/10 dark:text-gray-200">No</span>
                  @endif
                </td>
                <td class="py-3 pr-4">
                  <div class="flex gap-2">
                    <a class="inline-flex items-center rounded-xl bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:opacity-90"
                       href="{{ route('admin.lands.edit', $land) }}">Edit</a>

                    <form method="POST" action="{{ route('admin.lands.destroy', $land) }}"
                          onsubmit="return confirm('Delete this land?')">
                      @csrf
                      @method('DELETE')
                      <button class="inline-flex items-center rounded-xl bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:opacity-90">
                        Delete
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
