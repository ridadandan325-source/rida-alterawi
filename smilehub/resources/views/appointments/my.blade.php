@extends('layouts.site')

@section('content')
<div class="container">
    <div class="bg-white p-4 rounded-4 shadow-sm">

        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h2 class="mb-0">My Appointments</h2>
                <div class="text-muted">كل المواعيد اللي حجزتها</div>
            </div>
            <a class="btn btn-primary" href="{{ route('appointments.create') }}">+ New</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($appointments->isEmpty())
            <div class="alert alert-info mb-0">ما عندك مواعيد لحد الآن.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Patient</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $a)
                            <tr>
                                <td>{{ $a->date }}</td>
                                <td>{{ substr($a->time, 0, 5) }}</td>
                                <td>{{ $a->patient_name }}</td>
                                <td>{{ $a->phone }}</td>
                                <td>
                                    @if($a->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($a->status === 'confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                    @else
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $a->note ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</div>
@endsection
