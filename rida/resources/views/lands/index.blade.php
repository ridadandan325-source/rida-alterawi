<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
                    My Lands
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                    Manage your lands, edit details, and view them on the map.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <x-btn variant="primary" href="{{ route('lands.create') }}">+ Add Land</x-btn>
                <x-btn variant="secondary" href="{{ url('/map') }}">Public Map</x-btn>
                @if(Route::has('sales.index'))
                    <x-btn variant="secondary" href="{{ route('sales.index') }}">My Sales</x-btn>
                @endif
                @if(Route::has('purchases.index'))
                    <x-btn variant="secondary" href="{{ route('purchases.index') }}">My Purchases</x-btn>
                @endif
            </div>
        </div>
    </x-slot>

    @if($lands->count() === 0)
        <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm dark:bg-white/5 dark:border-white/10">
            <p class="text-gray-700 dark:text-gray-200">
                No lands yet. Click <b>Add Land</b> to create your first one.
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($lands as $land)
                <div class="rounded-3xl border border-gray-200 bg-white shadow-sm overflow-hidden dark:bg-white/5 dark:border-white/10">
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ $land->title }}
                                </h3>
                                @if($land->description)
                                    <p class="text-sm text-gray-500 dark:text-gray-300 mt-1 line-clamp-2">
                                        {{ $land->description }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 dark:text-gray-400 mt-1">
                                        No description
                                    </p>
                                @endif
                            </div>

                            @if($land->is_for_sale)
                                <x-badge type="sale">For Sale</x-badge>
                            @else
                                <x-badge type="sold">Sold</x-badge>
                            @endif
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-3 dark:bg-white/5 dark:border-white/10">
                                <div class="text-xs text-gray-500 dark:text-gray-300">Price</div>
                                <div class="font-bold text-gray-900 dark:text-white">
                                    {{ number_format((float)$land->price, 2) }}
                                </div>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-3 dark:bg-white/5 dark:border-white/10">
                                <div class="text-xs text-gray-500 dark:text-gray-300">Created</div>
                                <div class="font-bold text-gray-900 dark:text-white">
                                    {{ $land->created_at?->format('Y-m-d') }}
                                </div>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-3 col-span-2 dark:bg-white/5 dark:border-white/10">
                                <div class="text-xs text-gray-500 dark:text-gray-300">Location</div>
                                <div class="font-mono text-xs text-gray-700 dark:text-gray-200 mt-1">
                                    Lat: {{ $land->lat }} <span class="mx-2">•</span> Lng: {{ $land->lng }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 flex flex-wrap gap-2">
                            <x-btn variant="blue" href="{{ url('/map?land_id='.$land->id) }}">Show on Map</x-btn>

                            @if($land->is_for_sale)
                                <x-btn variant="secondary" href="{{ route('lands.edit', $land) }}">Edit</x-btn>

                                <form method="POST" action="{{ route('lands.destroy', $land) }}"
                                      onsubmit="return confirm('Delete this land?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="inline-flex items-center justify-center rounded-2xl px-4 py-2.5 text-sm font-semibold transition shadow-sm bg-red-600 text-white hover:opacity-90">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <span class="inline-flex items-center justify-center rounded-2xl px-4 py-2.5 text-sm font-semibold bg-gray-100 text-gray-500 dark:bg-white/10 dark:text-gray-300 cursor-not-allowed">
                                    Edit
                                </span>
                                <span class="inline-flex items-center justify-center rounded-2xl px-4 py-2.5 text-sm font-semibold bg-gray-100 text-gray-500 dark:bg-white/10 dark:text-gray-300 cursor-not-allowed">
                                    Delete
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
