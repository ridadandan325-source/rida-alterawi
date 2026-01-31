@extends('layouts.authenticated')

@section('title', 'تفاصيل سجل العلاج')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تفاصيل سجل العلاج</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @if(auth()->user()->hasAnyRole(['admin', 'dentist']) && (auth()->user()->hasRole('admin') || $treatmentNote->dentist_id == auth()->id()))
        <a href="{{ route('treatment-notes.edit', $treatmentNote) }}" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-1"></i> تعديل
        </a>
        @endif
        <a href="{{ route('treatment-notes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right me-1"></i> رجوع
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-file-medical me-2"></i> معلومات العلاج</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">العنوان:</div>
                    <div class="col-md-8">{{ $treatmentNote->title }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">المريض:</div>
                    <div class="col-md-8">
                        <a href="{{ route('patients.show', $treatmentNote->patient) }}">{{ $treatmentNote->patient->full_name }}</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">الطبيب:</div>
                    <div class="col-md-8">{{ $treatmentNote->dentist->name }}</div>
                </div>
                @if($treatmentNote->appointment)
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">الموعد المرتبط:</div>
                    <div class="col-md-8">
                        <a href="{{ route('appointments.show', $treatmentNote->appointment) }}">
                            {{ $treatmentNote->appointment->start_at->format('Y-m-d H:i') }}
                        </a>
                    </div>
                </div>
                @endif
                @if($treatmentNote->tooth_number)
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">رقم السن:</div>
                    <div class="col-md-8">{{ $treatmentNote->tooth_number }}</div>
                </div>
                @endif
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">وصف العلاج:</div>
                    <div class="col-md-8">
                        <div class="border p-3 bg-light rounded">
                            {!! nl2br(e($treatmentNote->description)) !!}
                        </div>
                    </div>
                </div>
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
                    <div class="fw-bold mb-1">رقم السجل:</div>
                    <div class="text-muted">#{{ $treatmentNote->id }}</div>
                </div>
                <div class="mb-3">
                    <div class="fw-bold mb-1">تاريخ الإنشاء:</div>
                    <div class="text-muted">{{ $treatmentNote->created_at->format('Y-m-d H:i') }}</div>
                </div>
                <div class="mb-3">
                    <div class="fw-bold mb-1">آخر تحديث:</div>
                    <div class="text-muted">{{ $treatmentNote->updated_at->format('Y-m-d H:i') }}</div>
                </div>
            </div>
        </div>

        @if(auth()->user()->hasAnyRole(['admin', 'dentist']) && (auth()->user()->hasRole('admin') || $treatmentNote->dentist_id == auth()->id()))
        <div class="card">
            <div class="card-body">
                <form action="{{ route('treatment-notes.destroy', $treatmentNote) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash me-1"></i> حذف السجل
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
