@extends('layouts.authenticated')

@section('title', 'التقارير والإحصائيات')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">التقارير والإحصائيات</h1>
    </div>

    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">إجمالي المرضى</h6>
                            <h2 class="mt-2 mb-0">{{ $stats['total_patients'] }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">المواعيد اليوم</h6>
                            <h2 class="mt-2 mb-0">{{ $stats['today_appointments'] }}</h2>
                        </div>
                        <i class="bi bi-calendar-event fs-1 opacity-50"></i>
                    </div>
                    <small class="card-footer text-white-50">القادمة: {{ $stats['upcoming_appointments'] }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">إيرادات الشهر</h6>
                            <h2 class="mt-2 mb-0">{{ number_format($stats['monthly_revenue'], 2) }}</h2>
                        </div>
                        <i class="bi bi-currency-dollar fs-1 opacity-50"></i>
                    </div>
                    <small class="card-footer text-white-50">الإجمالي:
                        {{ number_format($stats['total_revenue'], 2) }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-danger h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">فواتير غير مدفوعة</h6>
                            <h2 class="mt-2 mb-0">{{ $stats['unpaid_invoices_count'] }}</h2>
                        </div>
                        <i class="bi bi-exclamation-circle fs-1 opacity-50"></i>
                    </div>
                    <small class="card-footer text-white-50">القيمة:
                        {{ number_format($stats['unpaid_invoices_amount'], 2) }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Appointments -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>آخر المواعيد</span>
                    <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>المريض</th>
                                    <th>التاريخ</th>
                                    <th>الوقت</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAppointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->patient->full_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->start_at)->format('Y-m-d') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->start_at)->format('H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3">لا توجد مواعيد حديثة</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>آخر المدفوعات</span>
                    <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>المريض</th>
                                    <th>المبلغ</th>
                                    <th>التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->invoice->patient->full_name }}</td>
                                        <td>{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3">لا توجد مدفوعات حديثة</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection