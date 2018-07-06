@include('_parts.header.header-material')
<body class="bg-grey-lighter font-body">

@if(Auth::check())
    @include('_parts.navbar.navbar-logged-in')
@else
    @include('_parts.navbar.navbar-not-logged-in')
@endif

<main class="float-left w-full py-lg">
    @yield('content')
</main>

@include('_parts.footer')