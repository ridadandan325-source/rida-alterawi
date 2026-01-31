<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-semibold mb-0">خريطة الأراضي</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                العودة للوحة التحكم
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <!-- Map Container -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h3 class="h5 fw-semibold mb-1">خريطة الأراضي</h3>
                    <p class="text-muted small mb-0">انقر على أي أرض لعرض التفاصيل</p>
                </div>
                
                <!-- Map Grid -->
                <div class="card-body p-4">
                    <div class="row g-2 mx-auto" style="max-width: 600px;" id="land-map">
                        @for($y = 0; $y < 10; $y++)
                            @for($x = 0; $x < 10; $x++)
                                @php
                                    $land = $lands->firstWhere(function($land) use ($x, $y) {
                                        return $land->x == $x && $land->y == $y;
                                    });
                                @endphp
                                <div class="col-1 p-0">
                                    <div 
                                        class="position-relative border rounded cursor-pointer transition-all overflow-hidden
                                        @if($land)
                                            @if($land->owner_id)
                                                @if($land->owner_id == auth()->id())
                                                    bg-success border-success border-2
                                                @else
                                                    bg-danger border-danger border-2
                                                @endif
                                            @else
                                                bg-light border-secondary
                                            @endif
                                        @else
                                            bg-secondary-subtle border-secondary-subtle
                                        @endif
                                        "
                                        style="aspect-ratio: 1;"
                                        @if($land)
                                            onclick="showLandDetails({{ $land->id }})"
                                            title="{{ $land->name }} - {{ $land->price }} $"
                                        @endif
                                    >
                                        @if($land)
                                            <div class="position-absolute top-50 start-50 translate-middle">
                                                @if($land->owner_id)
                                                    @if($land->owner_id == auth()->id())
                                                        <svg class="text-white" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="text-white" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @endif
                                                @else
                                                    <svg class="text-secondary" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 text-white text-center" style="font-size: 8px; padding: 2px;">
                                                {{ number_format($land->price) }}$
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endfor
                        @endfor
                    </div>
                </div>

                <!-- Legend -->
                <div class="card-footer bg-light">
                    <div class="d-flex flex-wrap gap-4 small">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-success border border-success border-2 rounded" style="width: 24px; height: 24px;"></div>
                            <span>أرضك</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-danger border border-danger border-2 rounded" style="width: 24px; height: 24px;"></div>
                            <span>مملوكة</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-light border border-secondary border-2 rounded" style="width: 24px; height: 24px;"></div>
                            <span>متاحة للشراء</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-secondary-subtle border border-secondary-subtle border-2 rounded" style="width: 24px; height: 24px;"></div>
                            <span>فارغة</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showLandDetails(landId) {
            window.location.href = `/lands/${landId}`;
        }
    </script>
</x-app-layout>
