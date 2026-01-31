@extends('layouts.authenticated')

@section('title', 'إضافة سجل علاج جديد')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إضافة سجل علاج جديد</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('treatment-notes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right me-1"></i> رجوع
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('treatment-notes.store') }}" method="POST" id="treatmentNoteForm">
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
                            <option value="{{ $patient->id }}" {{ (old('patient_id') == $patient->id || request('patient_id') == $patient->id) ? 'selected' : '' }}>
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
                            required
                            {{ auth()->user()->hasRole('dentist') && !auth()->user()->hasRole('admin') ? 'readonly' : '' }}>
                        @foreach($dentists as $dentist)
                            <option value="{{ $dentist->id }}" {{ (old('dentist_id') == $dentist->id || (auth()->user()->hasRole('dentist') && auth()->id() == $dentist->id)) ? 'selected' : '' }}>
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
                    <label for="appointment_id" class="form-label">الموعد (اختياري)</label>
                    <select class="form-select @error('appointment_id') is-invalid @enderror" 
                            id="appointment_id" 
                            name="appointment_id">
                        <option value="">لا يوجد موعد مرتبط</option>
                        @foreach($appointments as $appointment)
                            <option value="{{ $appointment->id }}" {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                                {{ $appointment->start_at->format('Y-m-d H:i') }} - {{ $appointment->patient->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('appointment_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">سيتم تحديث قائمة المواعيد عند اختيار المريض</small>
                </div>

                <div class="col-md-6">
                    <label for="tooth_number" class="form-label">رقم السن</label>
                    <input type="text" 
                           class="form-control @error('tooth_number') is-invalid @enderror" 
                           id="tooth_number" 
                           name="tooth_number" 
                           value="{{ old('tooth_number') }}"
                           placeholder="مثال: 16, 21-25">
                    @error('tooth_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">عنوان العلاج <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('title') is-invalid @enderror" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
                       required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">وصف العلاج <span class="text-danger">*</span></label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" 
                          name="description" 
                          rows="6" 
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('treatment-notes.index') }}" class="btn btn-secondary">إلغاء</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> حفظ
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('patient_id').addEventListener('change', function() {
        const patientId = this.value;
        if (patientId) {
            // Reload page with patient_id parameter to load appointments
            window.location.href = '{{ route("treatment-notes.create") }}?patient_id=' + patientId;
        } else {
            // Remove patient_id parameter
            window.location.href = '{{ route("treatment-notes.create") }}';
        }
    });
</script>
@endpush
@endsection
