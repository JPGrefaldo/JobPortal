@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,600|Noto+Sans:400,600" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
   
    <title>Crew Calls</title>

    <script src="js/jquery.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/scroll.js"></script>
    <script src="js/scripts.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../css/slick.css">
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/extras.css">
</head>

<body class="bg-grey-lighter font-body">
@section('content')

    @include('_parts.navbar.navbar-not-logged-in')

<main class="float-left w-full py-lg">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
        <div class="container max-w-xl">
            <div class="mb-3 md:mb-0 px-4">
                <div class="bg-white shadow-md rounded">
                    <div class="p-8">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h2 class="font-header text-blue-dark text-lg text-center font-semibold">Sign in</h2>
                        <div class="py-2 text-center">
                            <p class="leading-normal text-blue-dark">Sign in to view project/role details and edit your profile.</p>
                        </div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Email</label>
                        
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                        </div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Password
                                <a href="#" class="underline text-grey text-sm float-right font-normal">Forgot your password?</a>
                            </label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="py-2">
                            <label class="md:w-2/3 block">
                                <input class="mr-1" type="checkbox"> Remember me
                            </label>
                        </div>
                        <div class="pt-6">
                            <a class="block font-header bg-blue font-bold rounded-full hover:bg-green" style="text-align: center;"><button style="text-align: center;" class="uppercase text-sm p-4 text-center text-white" type="submit">Log in</button></a>
                        </div>
                    </div>
                </form>
                    <div class="p-8 text-center bg-grey-lighter border-top border-grey-light">
                        Not a member yet?
                        <a href="#" class="text-red underline hover:text-green">Sign up now</a>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-md-4"></div>
            </div>
        </div>
    </main>

@include('_parts/footer')

@endsection
