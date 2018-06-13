<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,600|Noto+Sans:400,600" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Crew Calls') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <script src="js/jquery.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/scroll.js"></script>
    <script src="js/scripts.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">

    <!-- Styles -->
    <link rel="stylesheet" href="/css/slick.css">
    <link rel="stylesheet" href="/css/output.css">
    <link rel="stylesheet" href="/css/extras.css">
</head>
<body>
    <div id="app">
        <nav class="bg-white float-left w-full px-3 md:px-6 shadow flex justify-between items-center font-header">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                   <!--  {{ config('app.name', 'Crew Calls') }} -->
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <div class="w-32 md:w-64 py-1 md:py-0 relative z-10">
                            <a href="/">
                                <img src="../images/logo-long.svg" alt="crew calls" /></a>
                        </div>


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto list-reset hidden md:flex items-center">
                        <!-- Authentication Links -->
                        <!-- <ul class="list-reset hidden md:flex items-center"> -->
        <li class="border-b-2 border-red border-solid">
            <a class="block py-6 px-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">my projects</a>
        </li>
        <li>
            <a class="block py-6 px-4 tracking-wide font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">find projects</a>
        </li>
        <li>
            <a class="block py-6 px-4 tracking-wide font-bold leading-none relative uppercase text-sm text-blue-dark hover:text-green"
                href="#">messages
                <span class="h-1 w-1 bg-red absolute rounded">
            </a>
        </li>
    <!-- </ul> -->

                    </ul>
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->email }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
