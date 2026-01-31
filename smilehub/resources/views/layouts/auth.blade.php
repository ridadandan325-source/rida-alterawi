@extends('layouts.site')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                @yield('auth-content')
            </div>
        </div>
    </div>
</div>
@endsection
