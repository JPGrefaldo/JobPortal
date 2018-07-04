@extends('layouts.default_layout')

<<<<<<< HEAD

<body class="bg-grey-lighter font-body">
@section('content')

@include('_parts/messages')

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
                                <a href="/password/reset" class="underline text-grey text-sm float-right font-normal">Forgot your password?</a>
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
                                <input class="mr-1" name="remember" type="checkbox"> Remember me
                            </label>
                        </div>
                        <div class="pt-6">
                            <a class="block font-header bg-blue font-bold rounded-full hover:bg-green" style="text-align: center;"><button style="text-align: center;" class="uppercase text-sm p-4 text-center text-white" type="submit">Log in</button></a>
                        </div>
                    </div>
                </form>
                    <div class="p-8 text-center bg-grey-lighter border-top border-grey-light">
                        Not a member yet?
                        <a href="/signup" class="text-red underline hover:text-green">Sign up now</a>
=======
@section('content')

<div class="container max-w-xl flex justify-center items-center">
    <div class="w-full md:w-1/2 float-left mb-3 md:mb-0 px-4">
        <div class="bg-white shadow-md rounded">
            <form method="post" action="{{ route('login') }}">
                <div class="p-8">
                    <h2 class="font-header text-blue-dark text-lg text-center font-semibold">Sign in</h2>
                    <div class="py-2 text-center">
                        <p class="leading-normal text-blue-dark">Sign in to view project/role details and edit your profile.</p>
                    </div>
                    <div class="py-2">
                        <label class="block font-semibold mb-2" for="email">Email</label>
                        <input name="email" class="w-full form-control @include('_parts.errors.input-error', ['input_element' => 'email'])" id="email" type="email" placeholder="Email">
                        @include('_parts.errors.input-error-message', ['input_element' => 'email'])
                    </div>
                    <div class="py-2">
                        <label class="block font-semibold mb-2" for="password">Password
                            <a href="{{ route('password.request') }}" class="underline text-grey text-sm float-right font-normal">Forgot your password?</a>
                        </label>
                        <input name="password" id="password" class="w-full form-control @include('_parts.errors.input-error', ['input_element' => 'email'])" type="password" placeholder="Password">
                        @include('_parts.errors.input-error-message', ['input_element' => 'password'])
                    </div>
                    <div class="py-2">
                        <label class="md:w-2/3 block">
                            <input name="remember" class="mr-1" type="checkbox"> Remember me
                        </label>
                    </div>
                    <div class="pt-6">
                        @csrf
                        <input type="submit" href="#" class="block font-header uppercase text-sm p-4 w-full text-center text-white bg-blue font-bold rounded-full hover:bg-green" value="Sign In">
>>>>>>> ed08429190ed881d583e906d79f5fd4c0e0f89be
                    </div>
                </div>
            </form>
            <div class="p-8 text-center bg-grey-lighter border-top border-grey-light">
                Not a member yet?
                <a href="{{ route('show.register') }}" class="text-red underline hover:text-green">Sign up now</a>
            </div>
        </div>
<<<<<<< HEAD
    </main>

@endsection
=======
    </div>
</div>

@endsection
>>>>>>> ed08429190ed881d583e906d79f5fd4c0e0f89be
