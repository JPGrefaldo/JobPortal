@extends('layouts.app')
@include('_parts/header')

<body class="bg-grey-lighter font-body">
@section('content')

    @include('_parts/nav')

<main class="float-left w-full py-lg">
        <div class="container max-w-xl">
            <div class="float-left mb-3 md:mb-0 px-4">
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
    </main>

@include('_parts/footer')

@endsection
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->


