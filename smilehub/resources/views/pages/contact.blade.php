@extends('layouts.site')

@section('content')
<div class="container">

    <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
        <h2 class="mb-1">Contact Us</h2>
        <p class="text-muted mb-0">نحن جاهزون لأي استفسار</p>
    </div>

    <div class="row g-4">
        <div class="col-md-5">
            <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                <h5 class="fw-bold mb-3">Clinic Info</h5>

                <div class="mb-2"><strong>📞 Phone:</strong> 0770629980</div>
                <div class="mb-2"><strong>📧 Email:</strong> info@smilehub.com</div>
                <div class="mb-2"><strong>📍 Location:</strong> Amman, Jordan</div>

                <hr>

                <div class="text-muted small">
                    Sat - Thu: 10:00 AM – 8:00 PM<br>
                    Friday: Closed
                </div>

                <div class="bg-light rounded-4 p-3 mt-3 text-center text-muted">
                    Map Placeholder
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                <h5 class="fw-bold mb-3">Send a Message</h5>

                <form>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input class="form-control" placeholder="Your name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" placeholder="you@example.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" rows="4" placeholder="Write your message..."></textarea>
                    </div>

                    <button type="button" class="btn btn-primary">
                        Send Message (Frontend only)
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
