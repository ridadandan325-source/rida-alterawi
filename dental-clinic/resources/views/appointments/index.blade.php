@extends('layouts.authenticated')

@section('title', 'المواعيد')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إدارة المواعيد</h1>
    @if(auth()->user()->hasAnyRole(['admin', 'receptionist']))
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> إضافة موعد جديد
        </a>
    </div>
    @endif
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('appointments.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="date_from" class="form-label">من تاريخ</label>
                <input type="date" 
                       name="date_from" 
                       id="date_from"
                       class="form-control" 
                       value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label for="date_to" class="form-label">إلى تاريخ</label>
                <input type="date" 
                       name="date_to" 
                       id="date_to"
                       class="form-control" 
                       value="{{ request('date_to') }}">
            </div>
            @if(auth()->user()->hasAnyRole(['admin', 'receptionist']) && $dentists)
            <div class="col-md-3">
                <label for="dentist_id" class="form-label">الطبيب</label>
                <select name="dentist_id" id="dentist_id" class="form-select">
                    <option value="">جميع الأطباء</option>
                    @foreach($dentists as $dentist)
                        <option value="{{ $dentist->id }}" {{ request('dentist_id') == $dentist->id ? 'selected' : '' }}>
                            {{ $dentist->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-md-3">
                <label for="status" class="form-label">الحالة</label>
                <select name="status" id="status" class="form-select">
                    <option value="">جميع الحالات</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                    <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>لم يحضر</option>
                </select>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> بحث
                </button>
                @if(request()->anyFilled(['date_from', 'date_to', 'dentist_id', 'status']))
                <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i> إلغاء الفلترة
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Appointments Table -->
<div class="card">
    <div class="card-body">
        @if($appointments->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المريض</th>
                        <th>الطبيب</th>
                        <th>تاريخ ووقت البداية</th>
                        <th>تاريخ ووقت النهاية</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->patient->full_name }}</td>
                        <td>{{ $appointment->dentist->name }}</td>
                        <td>{{ $appointment->start_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $appointment->end_at->format('Y-m-d H:i') }}</td>
                        <td>
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
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-info" title="عرض">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(auth()->user()->hasAnyRole(['admin', 'receptionist']))
                                <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-warning" title="تعديل">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموعد؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $appointments->appends(request()->query())->links() }}
        </div>
        @else
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-2"></i>
            لا توجد مواعيد مسجلة
        </div>
        @endif
    </div>
</div>
@endsection
