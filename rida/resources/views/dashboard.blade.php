<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
                    Dashboard
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                    Quick overview of your activity.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <x-btn variant="primary" href="{{ route('lands.create') }}">+ Add Land</x-btn>
                <x-btn variant="secondary" href="{{ url('/map') }}">Open Map</x-btn>
            </div>
        </div>
    </x-slot>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
        <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:bg-white/5 dark:border-white/10">
            <div class="text-sm text-gray-500 dark:text-gray-300">My Lands</div>
            <div class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ $totalLands }}</div>
        </div>

        <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:bg-white/5 dark:border-white/10">
            <div class="text-sm text-gray-500 dark:text-gray-300">For Sale</div>
            <div class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ $forSaleLands }}</div>
        </div>

        <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:bg-white/5 dark:border-white/10">
            <div class="text-sm text-gray-500 dark:text-gray-300">Sold (Owned)</div>
            <div class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ $soldLands }}</div>
        </div>

        <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:bg-white/5 dark:border-white/10">
            <div class="text-sm text-gray-500 dark:text-gray-300">Purchases</div>
            <div class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ $purchasesCount }}</div>
        </div>

        <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:bg-white/5 dark:border-white/10">
            <div class="text-sm text-gray-500 dark:text-gray-300">Sales</div>
            <div class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-white">{{ $salesCount }}</div>
        </div>
    </div>

    {{-- Recent activity --}}
    <div class="mt-6 grid grid-cols-1 xl:grid-cols-2 gap-4">

        {{-- Latest Purchases --}}
        <div class="rounded-3xl border border-gray-200 bg-white shadow-sm dark:bg-white/5 dark:border-white/10">
            <div class="p-5 border-b border-gray-200 dark:border-white/10 flex items-center justify-between">
                <div>
                    <div class="font-bold text-gray-900 dark:text-white">Latest Purchases</div>
                    <div class="text-sm text-gray-500 dark:text-gray-300">Last 5 items you bought</div>
                </div>
                <x-btn variant="secondary" href="{{ route('purchases.index') }}">View all</x-btn>
            </div>

            <div class="p-5 space-y-3">
                @forelse($latestPurchases as $p)
                    <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:bg-white/5 dark:border-white/10">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="font-semibold text-gray-900 dark:text-white">
                                    {{ $p->land->title ?? 'Deleted land' }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-300 mt-1">
                                    Seller: {{ $p->seller->name ?? 'Unknown' }} • {{ $p->created_at->format('Y-m-d') }}
                                </div>
                            </div>
                            <div class="font-bold text-gray-900 dark:text-white">
                                {{ number_format((float)$p->price, 2) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 dark:text-gray-300">No purchases yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Latest Sales --}}
        <div class="rounded-3xl border border-gray-200 bg-white shadow-sm dark:bg-white/5 dark:border-white/10">
            <div class="p-5 border-b border-gray-200 dark:border-white/10 flex items-center justify-between">
                <div>
                    <div class="font-bold text-gray-900 dark:text-white">Latest Sales</div>
                    <div class="text-sm text-gray-500 dark:text-gray-300">Last 5 lands you sold</div>
                </div>
                <x-btn variant="secondary" href="{{ route('sales.index') }}">View all</x-btn>
            </div>

            <div class="p-5 space-y-3">
                @forelse($latestSales as $s)
                    <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:bg-white/5 dark:border-white/10">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="font-semibold text-gray-900 dark:text-white">
                                    {{ $s->land->title ?? 'Deleted land' }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-300 mt-1">
                                    Buyer: {{ $s->buyer->name ?? 'Unknown' }} • {{ $s->created_at->format('Y-m-d') }}
                                </div>
                            </div>
                            <div class="font-bold text-gray-900 dark:text-white">
                                {{ number_format((float)$s->price, 2) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 dark:text-gray-300">No sales yet.</p>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>
