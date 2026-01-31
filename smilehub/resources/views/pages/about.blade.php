@extends('layouts.site')

@section('content')
<div class="container">

    <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
        <h2 class="mb-1">About SmileHub</h2>
        <p class="text-muted mb-0">
SmileHub Clinic aims to provide modern dental care with a convenient and organized experience.
    </p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                <h5 class="fw-bold">Our Mission</h5>
                <p class="text-muted mb-0">A healthy smile for every patient.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                <h5 class="fw-bold">Our Vision</h5>
                <p class="text-muted mb-0"> The best dental treatment experience. </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                <h5 class="fw-bold">Why SmileHub</h5>
                <p class="text-muted mb-0">Organization, punctuality, excellent follow-up. </p>
            </div>
        </div>
    </div>

    <h3 class="mb-3">Our Team</h3>

    <div class="row g-3">
        @foreach(['Dr. Ahmad','Dr. Rania','Dr. Omar'] as $doctor)
            <div class="col-md-4">
                <div class="bg-white p-4 rounded-4 shadow-sm text-center h-100">
                    <div class="rounded-circle bg-light mx-auto mb-3" style="width:90px;height:90px;"></div>
                    <h6 class="fw-bold mb-0">{{ $doctor }}</h6>
                    <div class="text-muted small">Dental Specialist</div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
