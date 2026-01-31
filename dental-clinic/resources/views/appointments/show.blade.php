@extends('layouts.authenticated')

@section('title', 'تفاصيل الموعد')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تفاصيل الموعد</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @if(auth()->user()->hasAnyRole(['admin', 'receptionist']))
        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-1"></i> تعديل
        </a>
        @endif
        <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right me-1"></i> رجوع
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i> معلومات الموعد</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">المريض:</div>
                    <div class="col-md-8">{{ $appointment->patient->full_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">الطبيب:</div>
                    <div class="col-md-8">{{ $appointment->dentist->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">تاريخ ووقت البداية:</div>
                    <div class="col-md-8">{{ $appointment->start_at->format('Y-m-d H:i') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">تاريخ ووقت النهاية:</div>
                    <div class="col-md-8">{{ $appointment->end_at->format('Y-m-d H:i') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">المدة:</div>
                    <div class="col-md-8">{{ $appointment->start_at->diffInMinutes($appointment->end_at) }} دقيقة</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">الحالة:</div>
                    <div class="col-md-8">
                        @if($appointment->status == 'pending')
                            <span class="badge bg-warning">قيد الانتظار</span>
                        @elseif($appointment->status == 'confirmed')
                            <span class="badge bg-info">مؤكد</span>
                        @elseif($appointment->status == 'completed')
                            <span class="badge bg-success">مكتمل</span>
                        @elseif($appointment->status == 'cancelled')
                            <span class="badge bg-danger">ملغي</span>
                        @elseif($appointment->status == 'no_show')
                            <span class="badge bg-secondary">لم يحضر</span>
                        @endif
                    </div>
                </div>
                @if($appointment->reason)
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">سبب الموعد:</div>
                    <div class="col-md-8">{{ $appointment->reason }}</div>
                </div>
                @endif
                @if($appointment->notes)
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">ملاحظات:</div>
                    <div class="col-md-8">{{ $appointment->notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i> معلومات إضافية</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="fw-bold mb-1">رقم الموعد:</div>
                    <div class="text-muted">#{{ $appointment->id }}</div>
                </div>
                <div class="mb-3">
                    <div class="fw-bold mb-1">تاريخ الإنشاء:</div>
                    <div class="text-muted">{{ $appointment->created_at->format('Y-m-d H:i') }}</div>
                </div>
                <div class="mb-3">
                    <div class="fw-bold mb-1">آخر تحديث:</div>
                    <div class="text-muted">{{ $appointment->updated_at->format('Y-m-d H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        @if(auth()->user()->hasAnyRole(['admin', 'receptionist']))
        <div class="card mb-3">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-lightning me-2"></i> إجراءات سريعة</h5>
            </div>
            <div class="card-body">
                @if($appointment->status != 'confirmed')
                <form action="{{ route('appointments.confirm', $appointment) }}" method="POST" class="mb-2">
                    @csrf
                    <button type="submit" class="btn btn-info w-100">
                        <i class="bi bi-check-circle me-1"></i> تأكيد الموعد
                    </button>
                </form>
                @endif
                @if($appointment->status != 'cancelled')
                <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من إلغاء هذا الموعد؟');">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-x-circle me-1"></i> إلغاء الموعد
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endif

        @if(auth()->user()->hasRole('dentist') && $appointment->dentist_id == auth()->id())
        <div class="card mb-3">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-lightning me-2"></i> إجراءات سريعة</h5>
            </div>
            <div class="card-body">
                @if($appointment->status != 'completed')
                <form action="{{ route('appointments.update-status', $appointment) }}" method="POST" class="mb-2">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle me-1"></i> تم إكمال الموعد
                    </button>
                </form>
                @endif
                @if($appointment->status != 'no_show')
                <form action="{{ route('appointments.update-status', $appointment) }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="status" value="no_show">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="bi bi-person-x me-1"></i> لم يحضر المريض
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endif

        @if(auth()->user()->hasAnyRole(['admin', 'receptionist']))
        <div class="card">
            <div class="card-body">
                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموعد؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash me-1"></i> حذف الموعد
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
