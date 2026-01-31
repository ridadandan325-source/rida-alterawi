@extends('layouts.authenticated')

@section('title', 'الفواتير')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">الفواتير</h1>
        @if(auth()->user()->hasAnyRole(['admin', 'receptionist']))
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> إنشاء فاتورة جديدة
                </a>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            @if($invoices->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المريض</th>
                                <th>تاريخ الإصدار</th>
                                <th>المبلغ الإجمالي</th>
                                <th>المبلغ المدفوع</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->id }}</td>
                                    <td>{{ $invoice->patient->full_name }}</td>
                                    <td>{{ $invoice->issued_date->format('Y-m-d') }}</td>
                                    <td>{{ number_format($invoice->total_amount, 2) }}</td>
                                    <td>{{ number_format($invoice->paid_amount, 2) }}</td>
                                    <td>
                                        @if($invoice->status == 'paid')
                                            <span class="badge bg-success">مدفوعة</span>
                                        @elseif($invoice->status == 'partial')
                                            <span class="badge bg-warning text-dark">مدفوعة جزئياً</span>
                                        @else
                                            <span class="badge bg-danger">غير مدفوعة</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info"
                                                title="عرض">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if(auth()->user()->hasAnyRole(['admin', 'receptionist']))
                                                {{-- Edit/Delete could go here --}}
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $invoices->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>
                    لا توجد فواتير مسجلة
                </div>
            @endif
        </div>
    </div>
@endsection