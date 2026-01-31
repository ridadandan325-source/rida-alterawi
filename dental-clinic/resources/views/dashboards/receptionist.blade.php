@extends('layouts.authenticated')

@section('title', 'لوحة تحكم الاستقبال')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">لوحة تحكم الاستقبال</h1>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">المواعيد اليوم</h5>
                <h2 class="card-text">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">المرضى الجدد</h5>
                <h2 class="card-text">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-info">
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
                <h5 class="mb-0">المهام اليومية</h5>
            </div>
            <div class="card-body">
                <p>مرحباً بك في لوحة تحكم الاستقبال. يمكنك إدارة المهام التالية:</p>
                <ul>
                    <li>حجز المواعيد للمرضى</li>
                    <li>إدارة بيانات المرضى</li>
                    <li>عرض المواعيد اليومية</li>
                    <li>طباعة الفواتير</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
