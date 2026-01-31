@extends('layouts.authenticated')

@section('title', 'المرضى')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إدارة المرضى</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('patients.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> إضافة مريض جديد
        </a>
    </div>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('patients.index') }}" class="row g-3">
            <div class="col-md-10">
                <input type="text" 
                       name="search" 
                       class="form-control" 
                       placeholder="ابحث بالاسم، الهاتف، أو البريد الإلكتروني..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search me-1"></i> بحث
                </button>
            </div>
            @if(request('search'))
            <div class="col-12">
                <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-circle me-1"></i> إلغاء البحث
                </a>
            </div>
            @endif
        </form>
    </div>
</div>

<!-- Patients Table -->
<div class="card">
    <div class="card-body">
        @if($patients->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم الكامل</th>
                        <th>الهاتف</th>
                        <th>البريد الإلكتروني</th>
                        <th>الجنس</th>
                        <th>تاريخ الميلاد</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->full_name }}</td>
                        <td>{{ $patient->phone ?? '-' }}</td>
                        <td>{{ $patient->email ?? '-' }}</td>
                        <td>
                            @if($patient->gender == 'male')
                                <span class="badge bg-primary">ذكر</span>
                            @elseif($patient->gender == 'female')
                                <span class="badge bg-danger">أنثى</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $patient->birth_date ? $patient->birth_date->format('Y-m-d') : '-' }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-info" title="عرض">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-warning" title="تعديل">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المريض؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $patients->appends(request()->query())->links() }}
        </div>
        @else
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-2"></i>
            @if(request('search'))
                لم يتم العثور على نتائج للبحث "{{ request('search') }}"
            @else
                لا توجد مرضى مسجلين حتى الآن
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
