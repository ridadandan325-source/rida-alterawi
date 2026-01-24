<x-app-layout>
  <x-slot name="header">
    <div class="flex items-start justify-between gap-4">
      <div>
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">Admin Dashboard</h2>
        <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">System overview & latest activity.</p>
      </div>

      <div class="flex gap-2">
        <a href="{{ route('admin.lands.index') }}" class="inline-flex items-center rounded-2xl bg-black px-4 py-2.5 text-sm font-semibold text-white hover:opacity-90">Manage Lands</a>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center rounded-2xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold hover:bg-gray-50 dark:bg-white/5 dark:border-white/10 dark:text-white dark:hover:bg-white/10">Users</a>
        <a href="{{ route('admin.purchases.index') }}" class="inline-flex items-center rounded-2xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold hover:bg-gray-50 dark:bg-white/5 dark:border-white/10 dark:text-white dark:hover:bg-white/10">Purchases</a>
      </div>
    </div>
  </x-slot>

  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-4">
    <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:bg-white/5 dark:border-white/10">
      <div class="text-sm text-gray-500 dark:text-gray-300">Users</div>
      <div class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ $usersCount }}</div>
    </div>

    <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:bg-white/5 dark:border-white/10">
      <div class="text-sm text-gray-500 dark:text-gray-300">All Lands</div>
      <div class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ $landsCount }}</div>
    </div>

    <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:bg-white/5 dark:border-white/10">
      <div class="text-sm text-gray-500 dark:text-gray-300">For Sale</div>
      <div class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ $forSaleCount }}</div>
    </div>

    <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:bg-white/5 dark:border-white/10">
      <div class="text-sm text-gray-500 dark:text-gray-300">Sold</div>
      <div class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ $soldCount }}</div>
    </div>

    <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:bg-white/5 dark:border-white/10">
      <div class="text-sm text-gray-500 dark:text-gray-300">Purchases</div>
      <div class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ $purchasesCount }}</div>
    </div>

    <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:bg-white/5 dark:border-white/10">
      <div class="text-sm text-gray-500 dark:text-gray-300">Total Volume</div>
      <div class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ number_format((float)$totalVolume, 2) }}</div>
    </div>
  </div>

  <div class="mt-6 rounded-3xl border border-gray-200 bg-white shadow-sm dark:bg-white/5 dark:border-white/10 overflow-hidden">
    <div class="p-5 border-b border-gray-200 dark:border-white/10">
      <div class="font-bold text-gray-900 dark:text-white">Latest Purchases</div>
      <div class="text-sm text-gray-500 dark:text-gray-300">Last 6 transactions</div>
    </div>

    <div class="p-5 space-y-3">
      @forelse($latestPurchases as $p)
        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:bg-white/5 dark:border-white/10">
          <div class="flex items-start justify-between gap-3">
            <div>
              <div class="font-semibold text-gray-900 dark:text-white">{{ $p->land->title ?? 'Deleted land' }}</div>
              <div class="text-xs text-gray-500 dark:text-gray-300 mt-1">
                Buyer: {{ $p->buyer->name ?? 'Unknown' }} • Seller: {{ $p->seller->name ?? 'Unknown' }} • {{ $p->created_at->format('Y-m-d') }}
              </div>
            </div>
            <div class="font-bold text-gray-900 dark:text-white">{{ number_format((float)$p->price, 2) }}</div>
          </div>
        </div>
      @empty
        <div class="text-gray-600 dark:text-gray-300">No purchases yet.</div>
      @endforelse
    </div>
  </div>
</x-app-layout>
