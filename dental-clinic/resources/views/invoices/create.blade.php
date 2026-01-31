@extends('layouts.authenticated')

@section('title', 'إنشاء فاتورة جديدة')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">إنشاء فاتورة جديدة</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-right me-1"></i> عودة
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="patient_id" class="form-label">المريض <span class="text-danger">*</span></label>
                        <select name="patient_id" id="patient_id"
                            class="form-select @error('patient_id') is-invalid @enderror" required>
                            <option value="">اختر المريض...</option>
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
                        <label for="issued_date" class="form-label">تاريخ الإصدار <span class="text-danger">*</span></label>
                        <input type="date" name="issued_date" id="issued_date"
                            class="form-control @error('issued_date') is-invalid @enderror"
                            value="{{ old('issued_date', date('Y-m-d')) }}" required>
                        @error('issued_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="total_amount" class="form-label">المبلغ الإجمالي <span
                                class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="total_amount" id="total_amount"
                            class="form-control @error('total_amount') is-invalid @enderror"
                            value="{{ old('total_amount') }}" required>
                        @error('total_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                            required>
                            <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>غير مدفوعة</option>
                            <option value="partial" {{ old('status') == 'partial' ? 'selected' : '' }}>مدفوعة جزئياً</option>
                            <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>مدفوعة</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="due_date" class="form-label">تاريخ الاستحقاق</label>
                        <input type="date" name="due_date" id="due_date"
                            class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date') }}">
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> حفظ الفاتورة
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection