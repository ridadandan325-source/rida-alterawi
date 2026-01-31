@extends('layouts.authenticated')

@section('title', 'لوحة تحكم المدير')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">لوحة تحكم المدير</h1>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">إجمالي المرضى</h5>
                <h2 class="card-text">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">المواعيد اليوم</h5>
                <h2 class="card-text">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">الإيرادات الشهرية</h5>
                <h2 class="card-text">0 ر.س</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">المواعيد القادمة</h5>
                <h2 class="card-text">0</h2>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">نظرة عامة</h5>
            </div>
            <div class="card-body">
                <p>مرحباً بك في لوحة تحكم المدير. يمكنك إدارة جميع جوانب العيادة من هنا.</p>
                <ul>
                    <li>إدارة المستخدمين والأدوار</li>
                    <li>عرض التقارير والإحصائيات</li>
                    <li>إدارة المواعيد والمرضى</li>
                    <li>مراقبة المدفوعات والفواتير</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
