@include('_parts.header.header')
<body class="bg-grey-lighter font-body min-h-screen flex flex-col">

@if(Auth::check())
    @include('_parts.navbar.navbar-logged-in')
@else
    @include('_parts.navbar.navbar-not-logged-in')
@endif

<main class="float-left w-full py-lg flex-1" id="content">
    @include('_parts.messagebox')
    @yield('content')
</main>

@include('_parts.footer.footer')
