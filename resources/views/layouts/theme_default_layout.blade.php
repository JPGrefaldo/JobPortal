@include('_parts.header.header')
<body class="bg-grey-lighter font-body min-h-screen flex flex-col">

<main class="float-left w-full py-lg flex-1" id="content">
    @yield('content')
</main>

@include('_parts.footer.footer')