@extends('layouts.app')
@include('_parts/header')

<body class="bg-grey-lighter font-body">

@section('content')
    @include('_parts/nav')

<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('signup') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required>

                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required>

                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address Confirm') }}</label>

                            <div class="col-md-6">
                                <input id="email_confirmation" type="email" class="form-control{{ $errors->has('email_confirmation') ? ' is-invalid' : '' }}" name="email_confirmation" value="{{ old('email_confirmation') }}" required>

                                @if ($errors->has('email_confirmation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email_confirmation') }}</strong>
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
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required>

                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" value="1" name="receive_sms">
                        <input type="hidden" value="Crew" name="type">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

    <main class="float-left w-full py-lg">
        <div class="container max-w-xl">
            
            <div class="w-full float-left px-4">
                <div class="bg-white shadow-md rounded">
                    <div class="p-8 text-center border-b border-grey-light">
                        <h2 class="font-header text-blue-dark text-lg text-center font-semibold">Sign up</h2>
                    </div>
                    <div class="p-8">
                        <form method="POST" action="{{ route('signup') }}">
                        @csrf
                        <div class="pb-2 text-center">
                            <h4 class="uppercase text-sm">I WANT TO:</h4>
                        </div>
                        <div class="bg-white md:shadow md:border border-grey-light md:rounded-full overflow-hidden md:flex text-center items-stretch">
                            <a class="block text-center md:w-1/2 p-3 mb-2 md:mb-0 border rounded-full md:rounded-none border-grey-light text-blue-dark md:border-t-0 md:border-b-0 md:border-r hover:bg-green hover:text-white" href="#">Hire for a Project</a>
                            <a class="block border md:border-none border-grey-light md:border-none text-center text-blue-dark rounded-full md:rounded-none md:w-1/2 p-3 hover:bg-green hover:text-white" href="#">Work as Crew</a>
                        </div>
                        <div class="p-2 text-center text-sm text-grey">You can choose both</div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Full name</label>
                            <div class="flex">
                                <div class="w-1/2 md:pr-1">
                                    <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required>

                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                                </div>
                                <div class="w-1/2 md:pl-1">
                                    <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>

                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>

                        </div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Email</label>

                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email Address" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Email Confirmation</label>

                            <input id="email_confirmation" type="email" class="form-control{{ $errors->has('email_confirmation') ? ' is-invalid' : '' }}" name="email_confirmation" value="{{ old('email_confirmation') }}" placeholder="Confirm Email" required>

                                @if ($errors->has('email_confirmation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email_confirmation') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Password
                                <span class="underline text-grey text-sm float-right font-normal">At least 8 characters</span>
                            </label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Confirm Password
                            </label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="">Phone
                                
                            </label>
                            <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required>

                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <input type="hidden" value="1" name="receive_sms">
                        <input type="hidden" value="Crew" name="type">

                        <div class="py-2">
                            <label class="block">
                                <input class="mr-1" type="checkbox"> Receive text alerts <a href="#" class="float-right rounded-full bg-grey-light text-grey bold text-sm py-0 px-1">?</a>
                            </label>
                        </div>
                        <div class="pt-6">
                            <input type="submit" class="block font-header uppercase text-sm p-4 text-center text-white bg-blue font-bold rounded-full hover:bg-green" value="sign up">
                        </div>
                        <div class="py-4">
                            <p class="text-sm text-center">By joining, you agree with our <a href="/terms" class="text-red underline hover:text-green">Terms and Conditions</a></p>
                        </div>
                    </div>
                </form>
                    <div class="p-8 text-center bg-grey-lighter border-top border-grey-light">
                        Already a member?
                        <a href="/login" class="text-red underline hover:text-green">Sign in</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

@include('_parts/footer')

@endsection