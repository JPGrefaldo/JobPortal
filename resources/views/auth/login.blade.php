@extends('layouts.default_layout')

@section('content')

@section('content')
    @component('_parts.componets.single-card-button-page')
        @slot('cardContent')
            <h2 class="font-header text-blue-dark text-lg text-center font-semibold">Sign in</h2>
            <div class="py-2 text-center">
                <p class="leading-normal text-blue-dark">Sign in to view project/role details and edit your profile.</p>
            </div>
            <div class="py-2">
                <label class="block font-semibold mb-2" for="email">Email</label>
                <input name="email" class="w-full form-control @include('_parts.errors.input-error', ['input_element' => 'email'])" id="email" type="email" placeholder="Email">
            </div>
            <div class="py-2">
                <label class="block font-semibold mb-2" for="password">Password
                    <a href="{{ route('password.request') }}" class="underline text-grey text-sm float-right font-normal">Forgot your password?</a>
                </label>
                <input name="password" id="password" class="w-full form-control @include('_parts.errors.input-error', ['input_element' => 'email'])" type="password" placeholder="Password">
            </div>
            <div class="py-2">
                <label class="md:w-2/3 block">
                    <input name="remember" class="mr-1" type="checkbox"> Remember me
                </label>
            </div>
        @endslot
        @slot('cardRoute')
            {{ route('login') }}
        @endslot
        @slot('cardButtonValue')
            {{ __('Sign In') }}
        @endslot
        @slot('cardUnderContent')
            <div class="p-8 text-center bg-grey-lighter border-top border-grey-light">
                Not a member yet?
                <a href="{{ route('signup') }}" class="text-red underline hover:text-green">Sign up now</a>
            </div>
        @endslot
    @endcomponent
@endsection

