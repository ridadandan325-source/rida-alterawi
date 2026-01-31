@extends('layouts.authenticated')

@section('title', 'تفاصيل الفاتورة #' . $invoice->id)

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">تفاصيل الفاتورة #{{ $invoice->id }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-right me-1"></i> عودة للكائمة
            </a>
            @if(auth()->user()->hasAnyRole(['admin', 'receptionist']) && $invoice->status != 'paid')
                <a href="{{ route('payments.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-success">
                    <i class="bi bi-cash-coin me-1"></i> تسجيل دفعة
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    معلومات الفاتورة
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>المريض:</th>
                            <td>{{ $invoice->patient->full_name }}</td>
                        </tr>
                        <tr>
                            <th>تاريخ الإصدار:</th>
                            <td>{{ $invoice->issued_date->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <th>تاريخ الاستحقاق:</th>
                            <td>{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>الحالة:</th>
                            <td>
                                @if($invoice->status == 'paid')
                                    <span class="badge bg-success">مدفوعة</span>
                                @elseif($invoice->status == 'partial')
                                    <span class="badge bg-warning text-dark">مدفوعة جزئياً</span>
                                @else
                                    <span class="badge bg-danger">غير مدفوعة</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    الملخص المالي
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>المبلغ الإجمالي:</th>
                            <td class="fs-5 fw-bold">{{ number_format($invoice->total_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>المبلغ المدفوع:</th>
                            <td class="text-success">{{ number_format($invoice->paid_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>المتبقي:</th>
                            <td class="text-danger fw-bold">
                                {{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    سجل الدفعات
                </div>
                <div class="card-body">
                    @if($invoice->payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>المبلغ</th>
                                        <th>طريقة الدفع</th>
                                        <th>التاريخ</th>
                                        <th>ملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoice->payments as $payment)
                                        <tr>
                                            <td>{{ $payment->id }}</td>
                                            <td>{{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ ucfirst($payment->method) }}</td>
                                            <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                                            <td>{{ $payment->notes }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted my-3">لا توجد دفعات مسجلة لهذه الفاتورة.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection