@extends('layouts.default_layout')


@section('content')
    @component('_parts.components.single-card-button-page')
        @slot('cardContent')
            <h2 class="font-header text-blue-dark text-lg text-center font-semibold">{{ __('Reset Password') }}</h2>
            <div class="py-2 text-center">
                <p class="leading-normal text-blue-dark">Send email to reset password</p>
            </div>
            <div class="py-2">
                <label class="block font-semibold mb-2" for="email">Email</label>
                <input name="email" class="w-full form-control @include('_parts.errors.input-error', ['input_element' => 'email'])" id="email" type="email" placeholder="Email">
                @include('_parts.errors.input-error-message-inline', ['input_element' => 'email'])
            </div>
        @endslot
        @slot('cardRoute')
            {{ route('password.email') }}
        @endslot
        @slot('cardButtonValue')
            {{ __('Send Password Reset Link') }}
        @endslot
    @endcomponent
@endsection
