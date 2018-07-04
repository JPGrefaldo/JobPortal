@extends('layouts.default_layout')

@section('content')
<<<<<<< HEAD

<main class="float-left w-full py-lg">
<div class="container max-w-xl">
    <div class="mb-3 md:mb-0 px-4">
        <div class="p-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>
=======
>>>>>>> ed08429190ed881d583e906d79f5fd4c0e0f89be

    <div class="container max-w-xl flex justify-center items-center">
        <div class="w-full md:w-1/2 float-left mb-3 md:mb-0 px-4">
            <div class="bg-white shadow-md rounded">
                <form method="post" action="{{ route('password.email') }}">
                    <div class="p-8">
                        <h2 class="font-header text-blue-dark text-lg text-center font-semibold">{{ __('Reset Password') }}</h2>
                        <div class="py-2 text-center">
                            <p class="leading-normal text-blue-dark">Send email to reset password</p>
                        </div>
                        <div class="py-2">
                            <label class="block font-semibold mb-2" for="email">Email</label>
                            <input name="email" class="w-full form-control @include('_parts.errors.input-error', ['input_element' => 'email'])" id="email" type="email" placeholder="Email">
                            @include('_parts.errors.input-error-message', ['input_element' => 'email'])
                        </div>
                        <div class="pt-6">
                            @csrf
                            <input type="submit" href="#" class="block font-header uppercase text-sm p-4 text-center text-white bg-blue font-bold rounded-full hover:bg-green" value="{{ __('Send Password Reset Link') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<<<<<<< HEAD
</div>
</main>
@endsection
=======

@endsection
>>>>>>> ed08429190ed881d583e906d79f5fd4c0e0f89be
