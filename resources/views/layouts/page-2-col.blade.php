@extends('layouts.default_layout')

@section('content')

    <div class="max-w-screen-xl flex justify-center items-center py-md md:py-lg px-3">
        <div class="container">
            @yield('page-content')
        </div>
    </div>

@endsection
