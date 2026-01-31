@extends('layouts.authenticated')

@section('title', 'إضافة موعد جديد')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إضافة موعد جديد</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right me-1"></i> رجوع
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="patient_id" class="form-label">المريض <span class="text-danger">*</span></label>
                    <select class="form-select @error('patient_id') is-invalid @enderror" 
                            id="patient_id" 
                            name="patient_id" 
                            required>
                        <option value="">اختر المريض</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="dentist_id" class="form-label">الطبيب <span class="text-danger">*</span></label>
                    <select class="form-select @error('dentist_id') is-invalid @enderror" 
                            id="dentist_id" 
                            name="dentist_id" 
                            required>
                        <option value="">اختر الطبيب</option>
                        @foreach($dentists as $dentist)
                            <option value="{{ $dentist->id }}" {{ old('dentist_id') == $dentist->id ? 'selected' : '' }}>
                                {{ $dentist->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('dentist_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="start_at" class="form-label">تاريخ ووقت البداية <span class="text-danger">*</span></label>
                    <input type="datetime-local" 
                           class="form-control @error('start_at') is-invalid @enderror" 
                           id="start_at" 
                           name="start_at" 
                           value="{{ old('start_at') }}" 
                           required>
                    @error('start_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="end_at" class="form-label">تاريخ ووقت النهاية <span class="text-danger">*</span></label>
                    <input type="datetime-local" 
                           class="form-control @error('end_at') is-invalid @enderror" 
                           id="end_at" 
                           name="end_at" 
                           value="{{ old('end_at') }}" 
                           required>
                    @error('end_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="reason" class="form-label">سبب الموعد</label>
                <input type="text" 
                       class="form-control @error('reason') is-invalid @enderror" 
                       id="reason" 
                       name="reason" 
                       value="{{ old('reason') }}">
                @error('reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">ملاحظات</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" 
                          id="notes" 
                          name="notes" 
                          rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">إلغاء</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> حفظ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
