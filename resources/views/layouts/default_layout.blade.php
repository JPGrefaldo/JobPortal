@include('_parts.header.header')
<body class="bg-grey-lighter font-body h-screen flex flex-col">

@if(Auth::check())
    @include('_parts.navbar.navbar-logged-in')
@else
    @include('_parts.navbar.navbar-not-logged-in')
@endif

    @yield('content')
{{-- <main class="float-left w-full @if (Route::current()->getName() !== 'messages')) py-lg @endif flex-1" id="content">
    @include('_parts.messagebox')
    @yield('content')
</main> --}}

@if (Route::current()->getName() !== 'messages')
    @include('_parts.footer.footer')
@else
    @include('_parts.footer.messenger')
@endif
