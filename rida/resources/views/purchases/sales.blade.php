<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
                    My Sold Lands
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                    Track lands you sold and who bought them.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <x-btn variant="secondary" href="{{ route('lands.index') }}">My Lands</x-btn>
                <x-btn variant="secondary" href="{{ url('/map') }}">Public Map</x-btn>
                @if(Route::has('purchases.index'))
                    <x-btn variant="secondary" href="{{ route('purchases.index') }}">My Purchases</x-btn>
                @endif
            </div>
        </div>
    </x-slot>

    @if($sales->count() === 0)
        <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm dark:bg-white/5 dark:border-white/10">
            <p class="text-gray-700 dark:text-gray-200">No sales yet.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($sales as $sale)
                <div class="rounded-3xl border border-gray-200 bg-white shadow-sm overflow-hidden dark:bg-white/5 dark:border-white/10">
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ $sale->land->title ?? 'Deleted land' }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                                    Sold on {{ $sale->created_at->format('Y-m-d') }}
                                </p>
                            </div>

                            <x-badge type="sold">Sold</x-badge>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-3 dark:bg-white/5 dark:border-white/10">
                                <div class="text-xs text-gray-500 dark:text-gray-300">Price</div>
                                <div class="font-bold text-gray-900 dark:text-white">
                                    {{ number_format((float)$sale->price, 2) }}
                                </div>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-3 dark:bg-white/5 dark:border-white/10">
                                <div class="text-xs text-gray-500 dark:text-gray-300">Buyer</div>
                                <div class="font-semibold text-gray-900 dark:text-white">
                                    {{ $sale->buyer->name ?? 'Unknown' }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-300">
                                    {{ $sale->buyer->email ?? '' }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 flex flex-wrap gap-2">
                            @if($sale->land)
                                <x-btn variant="blue" href="{{ url('/map?land_id='.$sale->land->id) }}">Show on Map</x-btn>
                            @else
                                <span class="inline-flex items-center justify-center rounded-2xl px-4 py-2.5 text-sm font-semibold bg-gray-100 text-gray-500 dark:bg-white/10 dark:text-gray-300 cursor-not-allowed">
                                    Map
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
