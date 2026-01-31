@extends('layouts.authenticated')

@section('title', 'تسجيل دفعة جديدة')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">تسجيل دفعة جديدة</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-right me-1"></i> عودة
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('payments.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="invoice_id" class="form-label">الفاتورة <span class="text-danger">*</span></label>
                        <select name="invoice_id" id="invoice_id"
                            class="form-select @error('invoice_id') is-invalid @enderror" required {{ isset($invoice) ? 'readonly style="pointer-events: none;"' : '' }}>
                            <option value="">اختر الفاتورة...</option>
                            @foreach($invoices as $inv)
                                <option value="{{ $inv->id }}" {{ (isset($invoice) && $invoice->id == $inv->id) ? 'selected' : (old('invoice_id') == $inv->id ? 'selected' : '') }}>
                                    #{{ $inv->id }} - {{ $inv->patient->full_name }} (المتبقي:
                                    {{ number_format($inv->total_amount - $inv->paid_amount, 2) }})
                                </option>
                            @endforeach
                        </select>
                        @if(isset($invoice))
                            <!-- Ensure value is submitted even if disabled/readonly might not (select readonly is tricky) -->
                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                        @endif
                        @error('invoice_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="amount" class="form-label">المبلغ <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" id="amount"
                            class="form-control @error('amount') is-invalid @enderror"
                            value="{{ old('amount', isset($invoice) ? ($invoice->total_amount - $invoice->paid_amount) : '') }}"
                            required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="method" class="form-label">طريقة الدفع <span class="text-danger">*</span></label>
                        <select name="method" id="method" class="form-select @error('method') is-invalid @enderror"
                            required>
                            <option value="cash" {{ old('method') == 'cash' ? 'selected' : '' }}>نقدي (Cash)</option>
                            <option value="card" {{ old('method') == 'card' ? 'selected' : '' }}>بطاقة (Card)</option>
                            <option value="insurance" {{ old('method') == 'insurance' ? 'selected' : '' }}>تأمين (Insurance)
                            </option>
                            <option value="transfer" {{ old('method') == 'transfer' ? 'selected' : '' }}>تحويل بنكي (Transfer)
                            </option>
                        </select>
                        @error('method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="notes" class="form-label">ملاحظات</label>
                        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror"
                            rows="1">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> حفظ الدفعة
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection