<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-semibold mb-0">تفاصيل الأرض</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('lands.map') }}" class="btn btn-outline-secondary btn-sm">
                    العودة للخريطة
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                    لوحة التحكم
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card border-0 shadow-sm">
                <!-- Header Image -->
                <div class="position-relative overflow-hidden" style="height: 300px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                        <svg class="mx-auto mb-3 opacity-75" width="96" height="96" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <h1 class="h2 fw-bold mb-2">{{ $land->name }}</h1>
                        <p class="h5 mb-0 opacity-75">موقع: ({{ $land->x }}, {{ $land->y }})</p>
                    </div>
                </div>

                <!-- Content -->
                <div class="card-body p-4">
                    <!-- Status Badge -->
                    <div class="mb-4">
                        @if($land->owner_id)
                            @if($land->owner_id == auth()->id())
                                <span class="badge bg-success-subtle text-success-emphasis px-3 py-2">
                                    <svg class="me-1" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    أرضك
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger-emphasis px-3 py-2">
                                    <svg class="me-1" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    مملوكة بواسطة: {{ $land->owner ? $land->owner->name : 'غير معروف' }}
                                </span>
                            @endif
                        @else
                            <span class="badge bg-info-subtle text-info-emphasis px-3 py-2">
                                <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                متاحة للشراء
                            </span>
                        @endif
                    </div>

                    <!-- Details Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="bg-light rounded p-4 border">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success bg-opacity-10 rounded p-3">
                                        <svg class="text-success" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-muted small mb-1">السعر</p>
                                        <p class="h4 fw-bold mb-0">${{ number_format($land->price, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light rounded p-4 border">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-info bg-opacity-10 rounded p-3">
                                        <svg class="text-info" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-muted small mb-1">المساحة</p>
                                        <p class="h4 fw-bold mb-0">{{ $land->size }} م²</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light rounded p-4 border">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary bg-opacity-10 rounded p-3">
                                        <svg class="text-primary" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-muted small mb-1">النوع</p>
                                        <p class="h4 fw-bold mb-0 text-capitalize">{{ $land->type }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light rounded p-4 border">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-warning bg-opacity-10 rounded p-3">
                                        <svg class="text-warning" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-muted small mb-1">الموقع</p>
                                        <p class="h4 fw-bold mb-0">({{ $land->x }}, {{ $land->y }})</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($land->description)
                    <div class="mb-4">
                        <h3 class="h5 fw-semibold mb-3">الوصف</h3>
                        <div class="bg-light rounded p-4 border">
                            <p class="mb-0">{{ $land->description }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="d-flex flex-column flex-sm-row gap-3 pt-4 border-top">
                        @if(!$land->owner_id)
                            <button class="btn btn-success flex-fill">
                                شراء هذه الأرض
                            </button>
                        @elseif($land->owner_id == auth()->id())
                            <button class="btn btn-primary flex-fill">
                                إدارة الأرض
                            </button>
                        @endif
                        <a href="{{ route('lands.map') }}" class="btn btn-outline-secondary flex-fill">
                            العودة للخريطة
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
