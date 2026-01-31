@extends('layouts.site')

@section('content')
<div class="container">

    <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
        <div class="d-flex align-items-end justify-content-between flex-wrap gap-2">
            <div>
                <h2 class="mb-1">Our Services</h2>
                <p class="text-muted mb-0">خدمات SmileHub — رعاية متكاملة لابتسامتك</p>
            </div>
            <a class="btn btn-primary" href="{{ route('appointments.create') }}">Book Appointment</a>
        </div>
    </div>

    @php
    $services = [
        ['icon'=>'🧼','title'=>'Teeth Cleaning','desc'=>'Professional dental cleaning to remove plaque and tartar, promoting optimal oral health.'],
        ['icon'=>'🦷','title'=>'Fillings','desc'=>'High-quality restorative and cosmetic fillings to repair and protect damaged teeth.'],
        ['icon'=>'🧠','title'=>'Root Canal','desc'=>'Advanced root canal therapy to eliminate infection and relieve pain effectively.'],
        ['icon'=>'✨','title'=>'Whitening','desc'=>'Safe and effective teeth whitening for a brighter, confident smile.'],
        ['icon'=>'😁','title'=>'Braces','desc'=>'Comprehensive orthodontic treatments with personalized follow-up care.'],
        ['icon'=>'🔍','title'=>'Checkup','desc'=>'Thorough dental examination with precise diagnosis and treatment planning.'],
    ];
    @endphp

    <div class="row g-3">
        @foreach($services as $s)
            <div class="col-md-4">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100 service-card">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="fs-2">{{ $s['icon'] }}</div>
                        <h5 class="fw-bold mb-0">{{ $s['title'] }}</h5>
                    </div>
                    <p class="text-muted mb-0">{{ $s['desc'] }}</p>

                    <div class="mt-3">
                        <a href="{{ route('appointments.create') }}" class="btn btn-outline-primary btn-sm">
                            Book this service
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-white p-4 rounded-4 shadow-sm text-center mt-4">
        <h4 class="fw-bold mb-2">Not sure what you need?</h4>
        <div class="text-muted mb-3">Book a checkup and we’ll guide you.</div>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-lg">Book Checkup</a>
    </div>

</div>
@endsection
