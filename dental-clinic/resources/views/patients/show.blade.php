@extends('layouts.authenticated')

@section('title', 'تفاصيل المريض')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تفاصيل المريض</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-1"></i> تعديل
        </a>
        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right me-1"></i> رجوع
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i> المعلومات الشخصية</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">الاسم الكامل:</div>
                    <div class="col-md-8">{{ $patient->full_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">رقم الهاتف:</div>
                    <div class="col-md-8">{{ $patient->phone ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">البريد الإلكتروني:</div>
                    <div class="col-md-8">{{ $patient->email ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">الجنس:</div>
                    <div class="col-md-8">
                        @if($patient->gender == 'male')
                            <span class="badge bg-primary">ذكر</span>
                        @elseif($patient->gender == 'female')
                            <span class="badge bg-danger">أنثى</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">تاريخ الميلاد:</div>
                    <div class="col-md-8">{{ $patient->birth_date ? $patient->birth_date->format('Y-m-d') : '-' }}</div>
                </div>
                @if($patient->birth_date)
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">العمر:</div>
                    <div class="col-md-8">{{ $patient->birth_date->age }} سنة</div>
                </div>
                @endif
            </div>
        </div>

        @if($patient->address)
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i> العنوان</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $patient->address }}</p>
            </div>
        </div>
        @endif

        @if($patient->notes)
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="bi bi-sticky me-2"></i> الملاحظات</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $patient->notes }}</p>
            </div>
        </div>
        @endif

        <!-- Treatment Notes Section -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-heart-pulse me-2"></i> سجلات العلاج</h5>
                @if(auth()->user()->hasAnyRole(['admin', 'dentist']))
                <a href="{{ route('treatment-notes.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> إضافة سجل جديد
                </a>
                @endif
            </div>
            <div class="card-body">
                @if($patient->treatmentNotes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>العنوان</th>
                                <th>الطبيب</th>
                                <th>رقم السن</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient->treatmentNotes->take(5) as $note)
                            <tr>
                                <td>{{ $note->created_at->format('Y-m-d') }}</td>
                                <td>{{ Str::limit($note->title, 40) }}</td>
                                <td>{{ $note->dentist->name }}</td>
                                <td>{{ $note->tooth_number ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('treatment-notes.show', $note) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($patient->treatmentNotes->count() > 5)
                <div class="mt-3 text-center">
                    <a href="{{ route('treatment-notes.index', ['patient_id' => $patient->id]) }}" class="btn btn-outline-primary">
                        عرض جميع السجلات ({{ $patient->treatmentNotes->count() }})
                    </a>
                </div>
                @endif
                @else
                <p class="text-muted mb-0">لا توجد سجلات علاج مسجلة</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i> معلومات إضافية</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="fw-bold mb-1">رقم التسجيل:</div>
                    <div class="text-muted">#{{ $patient->id }}</div>
                </div>
                <div class="mb-3">
                    <div class="fw-bold mb-1">تاريخ التسجيل:</div>
                    <div class="text-muted">{{ $patient->created_at->format('Y-m-d H:i') }}</div>
                </div>
                <div class="mb-3">
                    <div class="fw-bold mb-1">آخر تحديث:</div>
                    <div class="text-muted">{{ $patient->updated_at->format('Y-m-d H:i') }}</div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route('patients.destroy', $patient) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المريض؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash me-1"></i> حذف المريض
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
