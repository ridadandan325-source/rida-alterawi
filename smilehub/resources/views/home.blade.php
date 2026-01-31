@extends('layouts.site')

@section('content')
<div class="container">

    <!-- HERO -->
    <div class="card-soft p-5 section">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">

                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 mb-3 soft-border bg-light">
                    <span>🦷</span>
                    <span class="small text-muted">Dental Clinic Appointment Booking</span>
                </div>

                <h1 class="display-6 fw-bold mb-2">SmileHub</h1>
                <p class="lead text-muted mb-4">
                    Book your dental appointment easily. Fast, simple, and organized.
                </p>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-lg">Book Appointment</a>

                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Create Account</a>
                    @endguest

                    <a href="{{ route('services') }}" class="btn btn-outline-secondary btn-lg">View Services</a>
                </div>

                <div class="row g-3 mt-4">
                    <div class="col-sm-4">
                        <div class="soft-border bg-light p-3 h-100 hover-lift">
                            <div class="fw-bold mb-1">Easy Booking</div>
                            <div class="text-muted small">Pick time and submit.</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="soft-border bg-light p-3 h-100 hover-lift">
                            <div class="fw-bold mb-1">Reminders</div>
                            <div class="text-muted small">Stay on schedule.</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="soft-border bg-light p-3 h-100 hover-lift">
                            <div class="fw-bold mb-1">Secure</div>
                            <div class="text-muted small">Your data is protected.</div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-5">
                <div class="card-soft p-4 text-white" style="background: linear-gradient(135deg, var(--brand), var(--brand-2));">
                    <h5 class="fw-bold mb-3 text-center">Clinic Hours</h5>

                    <div class="d-flex justify-content-between small">
                        <span>Sat - Thu</span>
                        <span class="fw-semibold">10:00 AM - 8:00 PM</span>
                    </div>
                    <div class="d-flex justify-content-between small mt-2">
                        <span>Friday</span>
                        <span class="fw-semibold">Closed</span>
                    </div>

                    <hr class="border-white opacity-25 my-3">

                    <div class="d-flex justify-content-between small">
                        <span>Phone</span>
                        <span class="fw-semibold">07 7062 9980</span>
                    </div>
                    <div class="d-flex justify-content-between small mt-2">
                        <span>Location</span>
                        <span class="fw-semibold">Amman, Jordan</span>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('appointments.create') }}" class="btn btn-light btn-sm fw-bold">
                            Quick Booking
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- WHY US -->
    <div class="section">
        <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
            <div>
                <h3 class="mb-0">Why Choose SmileHub?</h3>
                <div class="text-muted">Comfort, quality, and organized appointments.</div>
            </div>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('about') }}">Learn more</a>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card-soft p-4 h-100 hover-lift">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="fs-4">🧰</span>
                        <div class="fw-bold">Modern Equipment</div>
                    </div>
                    <div class="text-muted">Up-to-date tools and safe procedures.</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-soft p-4 h-100 hover-lift">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="fs-4">👩‍⚕️</span>
                        <div class="fw-bold">Professional Team</div>
                    </div>
                    <div class="text-muted">Friendly doctors and clear communication.</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-soft p-4 h-100 hover-lift">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="fs-4">⚡</span>
                        <div class="fw-bold">Fast Booking</div>
                    </div>
                    <div class="text-muted">Book in seconds and track your appointments.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- TESTIMONIALS -->
    <div class="section">
        <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
            <h3 class="mb-0">Patient Reviews</h3>
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('contact') }}">Contact us</a>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card-soft p-4 h-100 hover-lift">
                    <div class="fw-bold text-warning">★★★★★</div>
                    <div class="mt-2">“Very clean clinic and the booking was super easy.”</div>
                    <div class="text-muted small mt-3">— Ahmad</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-soft p-4 h-100 hover-lift">
                    <div class="fw-bold text-warning">★★★★★</div>
                    <div class="mt-2">“Great service, on time, and professional staff.”</div>
                    <div class="text-muted small mt-3">— Rania</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-soft p-4 h-100 hover-lift">
                    <div class="fw-bold text-warning">★★★★★</div>
                    <div class="mt-2">“I loved the reminders and the follow up. Highly recommend.”</div>
                    <div class="text-muted small mt-3">— Omar</div>
                </div>
            </div>
        </div>
    </div>

    <!-- FINAL CTA -->
    <div class="card-soft p-4 text-center">
        <h4 class="fw-bold mb-2">Ready to book your appointment?</h4>
        <div class="text-muted mb-3">Choose a time and submit your request.</div>
        <div class="d-flex justify-content-center gap-2 flex-wrap">
            <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-lg">Book Now</a>
            <a href="{{ route('services') }}" class="btn btn-outline-secondary btn-lg">See Services</a>
        </div>
    </div>

</div>
@endsection
