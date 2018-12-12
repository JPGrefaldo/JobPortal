@include('_parts.header.header')
<body class="bg-grey-lighter font-body flex flex-col @if (Route::current()->getName() === 'messages')) h-screen @else min-h-screen @endif">

@if(Auth::check())
    @include('_parts.navbar.navbar-logged-in')
@else
    @include('_parts.navbar.navbar-not-logged-in')
@endif

@if (Route::current()->getName() === 'messages')
    @yield('content')
@else
    <main class="float-left w-full py-lg flex-1" id="content">
        @include('_parts.messagebox')
        @yield('content')
    </main>
@endif

@if (Route::current()->getName() === 'messages')
    @include('_parts.footer.messenger')
@else
    @include('_parts.footer.footer')
@endif
