<x-app-layout>
  <x-slot name="header">
    <div class="flex items-start justify-between gap-4">
      <div>
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">Admin • Purchases</h2>
        <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">All transactions in the system.</p>
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
              <th class="py-2 pr-4">Land</th>
              <th class="py-2 pr-4">Buyer</th>
              <th class="py-2 pr-4">Seller</th>
              <th class="py-2 pr-4">Price</th>
              <th class="py-2 pr-4">Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($purchases as $p)
              <tr class="border-b border-gray-100 dark:border-white/5">
                <td class="py-3 pr-4 font-semibold text-gray-900 dark:text-white">{{ $p->land->title ?? 'Deleted land' }}</td>
                <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ $p->buyer->name ?? 'Unknown' }} ({{ $p->buyer->email ?? '' }})</td>
                <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ $p->seller->name ?? 'Unknown' }} ({{ $p->seller->email ?? '' }})</td>
                <td class="py-3 pr-4 text-gray-900 dark:text-white">{{ number_format((float)$p->price, 2) }}</td>
                <td class="py-3 pr-4 text-gray-500 dark:text-gray-300 text-sm">{{ $p->created_at->format('Y-m-d') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</x-app-layout>
