@extends('layouts.authenticated')

@section('title', 'سجل المدفوعات')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">سجل المدفوعات</h1>
        @if(auth()->user()->hasAnyRole(['admin', 'receptionist']))
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('payments.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> تسجيل دفعة جديدة
                </a>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            @if($payments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الفاتورة</th>
                                <th>المريض</th>
                                <th>المبلغ</th>
                                <th>طريقة الدفع</th>
                                <th>التاريخ</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>
                                        <a href="{{ route('invoices.show', $payment->invoice_id) }}">
                                            #{{ $payment->invoice_id }}
                                        </a>
                                    </td>
                                    <td>{{ $payment->invoice->patient->full_name }}</td>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ ucfirst($payment->method) }}</td>
                                    <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        {{-- Actions if needed --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $payments->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>
                    لا توجد مدفوعات مسجلة
                </div>
            @endif
        </div>
    </div>
@endsection