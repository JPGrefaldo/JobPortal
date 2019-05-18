@extends('layouts.default_layout')

@section('content')

    <main class="max-w-screen-xl flex justify-center items-center py-md md:py-lg px-3">
        <div class="xl:w-1/2">
            @yield('page-content')
        </div>
    </main>

@endsection
