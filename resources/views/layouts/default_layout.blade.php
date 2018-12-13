@include('_parts.header.header')
<body class="bg-grey-lighter font-body flex flex-col @if (Route::current()->getName() === 'messages') h-screen @else min-h-screen @endif">

@if(Auth::check())
    @include('_parts.navbar.navbar-logged-in')
@else
    @include('_parts.navbar.navbar-not-logged-in')
@endif

<main id="content"
    class="flex-1 @if (Route::current()->getName() !== 'messages') float-left w-full py-lg @endif">
    @include('_parts.messagebox')
    @yield('content')
</main>

@if (Route::current()->getName() === 'messages')
    @include('_parts.footer.footer-javascript')
@else
    @include('_parts.footer.footer')
@endif
