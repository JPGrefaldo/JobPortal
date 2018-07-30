@extends('layouts.default_layout')

@section('content')

@include('_parts/messages')

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

                    </div>
                </div>
            </form>
            <div class="p-8 text-center bg-grey-lighter border-top border-grey-light">
                Not a member yet?
                <a href="{{ route('show.register') }}" class="text-red underline hover:text-green">Sign up now</a>
            </div>
        </div>

    </div>
</div>

@endsection
