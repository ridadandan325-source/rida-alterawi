@extends('layouts.auth')

@section('auth-content')
<h2 class="mb-1">Login</h2>
<p class="text-muted mb-4">  Sign in to SmileHub </p>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input class="form-control" type="password" name="password" required>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>

        @if (Route::has('password.request'))
            <a class="small" href="{{ route('password.request') }}">Forgot password?</a>
        @endif
    </div>

    <button class="btn btn-primary w-100">Login</button>

    <div class="text-center mt-3">
        <span class="text-muted"> Don't you have an account? </span>
        <a href="{{ route('register') }}">Register</a>
    </div>
@endsection
