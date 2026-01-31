@extends('layouts.authenticated')

@section('title', 'سجلات العلاج')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">سجلات العلاج</h1>
    @if(auth()->user()->hasAnyRole(['admin', 'dentist']))
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('treatment-notes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> إضافة سجل علاج جديد
        </a>
    </div>
    @endif
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('treatment-notes.index') }}" class="row g-3">
            @if(auth()->user()->hasAnyRole(['admin', 'receptionist']) && $patients)
            <div class="col-md-3">
                <label for="patient_id" class="form-label">المريض</label>
                <select name="patient_id" id="patient_id" class="form-select">
                    <option value="">جميع المرضى</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
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
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> بحث
                </button>
                @if(request()->anyFilled(['patient_id', 'dentist_id', 'date_from', 'date_to']))
                <a href="{{ route('treatment-notes.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i> إلغاء الفلترة
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Treatment Notes Table -->
<div class="card">
    <div class="card-body">
        @if($treatmentNotes->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المريض</th>
                        <th>الطبيب</th>
                        <th>العنوان</th>
                        <th>رقم السن</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($treatmentNotes as $note)
                    <tr>
                        <td>{{ $note->id }}</td>
                        <td>{{ $note->patient->full_name }}</td>
                        <td>{{ $note->dentist->name }}</td>
                        <td>{{ Str::limit($note->title, 50) }}</td>
                        <td>{{ $note->tooth_number ?? '-' }}</td>
                        <td>{{ $note->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('treatment-notes.show', $note) }}" class="btn btn-sm btn-info" title="عرض">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(auth()->user()->hasAnyRole(['admin', 'dentist']) && (auth()->user()->hasRole('admin') || $note->dentist_id == auth()->id()))
                                <a href="{{ route('treatment-notes.edit', $note) }}" class="btn btn-sm btn-warning" title="تعديل">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('treatment-notes.destroy', $note) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل؟');">
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
            {{ $treatmentNotes->appends(request()->query())->links() }}
        </div>
        @else
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-2"></i>
            لا توجد سجلات علاج مسجلة
        </div>
        @endif
    </div>
</div>
@endsection
