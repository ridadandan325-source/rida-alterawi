@extends('layouts.auth')

@section('auth-content')
<h2 class="mb-1">Register</h2>
<p class="text-muted mb-4">Create a new account in Smile Hub</p>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input class="form-control" type="password" name="password" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input class="form-control" type="password" name="password_confirmation" required>
    </div>

    <button class="btn btn-primary w-100">Create Account</button>

    <div class="text-center mt-3">
        <span class="text-muted">Do you have an account?</span>
        <a href="{{ route('login') }}">Login</a>
    </div>
@endsection
