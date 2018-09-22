@extends('layouts.default_layout')

@section('content')

@section('content')
    @component('_parts.components.single-card-button-page')
        @slot('cardTitle')
            <div class="p-8 text-center border-b border-grey-light">
                <h2 class="font-header text-blue-dark text-lg text-center font-semibold">Sign up</h2>
            </div>
        @endslot
        @slot('cardContent')
            <div class="pb-2 text-center">
                <h4 class="uppercase text-sm">I WANT TO:</h4>
            </div>
            <signup-type
                @if(in_array(\App\Models\Role::PRODUCER, old('type', []))) is-producer-active @endif
                @if(in_array(\App\Models\Role::CREW, old('type', []))) is-crew-active @endif
                producer-type="{{ \App\Models\Role::PRODUCER }}"
                crew-type="{{ \App\Models\Role::CREW }}"
            ></signup-type>
            <div class="p-2 text-center text-sm text-grey">You can choose both</div>
            <div class="py-2">
                <label class="block font-semibold mb-2" for="">Full name</label>
                <div class="flex">
                    <div class="w-1/2 md:pr-1">
                        <input name="first_name"
                               id="first_name"
                               class="w-full form-control @include('_parts.errors.input-error', ['input_element' => 'first_name'])"
                               value="{{ old('first_name') }}"
                               type="text"
                               placeholder="First name">
                        @include('_parts.errors.input-error-message-inline', ['input_element' => 'first_name'])
                    </div>
                    <div class="w-1/2 md:pl-1">
                        <input name="last_name"
                               id="last_name"
                               class="w-full form-control @include('_parts.errors.input-error', ['input_element' => 'last_name'])"
                               value="{{ old('last_name') }}"
                               type="text"
                               placeholder="Last name">
                        @include('_parts.errors.input-error-message-inline', ['input_element' => 'last_name'])
                    </div>
                </div>
            </div>
            <div class="py-2">
                <label class="block font-semibold mb-2" for="email">Email</label>
                <input name="email"
                       id="email"
                       class="w-full form-control @include('_parts.errors.input-error', ['input_element' => 'email'])"
                       value="{{ old('email') }}"
                       type="text"
                       placeholder="Email">
                @include('_parts.errors.input-error-message-inline', ['input_element' => 'email'])
            </div>
            <div class="py-2">
                <label class="block font-semibold mb-2" for="email_confirmation">Email Confirmation</label>
                <input name="email_confirmation" id="email_confirmation" value="{{ old('email_confirmation') }}" class="w-full form-control" type="text" placeholder="Email Confirmation">
            </div>
            <div class="py-2">
                <label class="block font-semibold mb-2" for="password">Password
                    <span class="underline text-grey text-sm float-right font-normal">At least 8 characters</span>
                </label>
                <input name="password"
                       id="password"
                       class="w-full form-control @include('_parts.errors.input-error', ['input_element' => 'password'])"
                       type="password"
                       placeholder="Password">
                @include('_parts.errors.input-error-message-inline', ['input_element' => 'password'])
            </div>
            <div class="py-2">
                <label class="block font-semibold mb-2" for="password_confirmation">Password Confirmation</label>
                <input name="password_confirmation" id="password_confirmation" class="w-full form-control" type="password" placeholder="Password Confirmation">
            </div>
            <div class="py-2">
                <label class="block font-semibold mb-2" for="">Phone</label>
                <input name="phone" class="w-full form-control @include('_parts.errors.input-error', ['input_element' => 'phone'])" value="{{ old('phone') }}" type="text" placeholder="(555) 555-5555">
                @include('_parts.errors.input-error-message-inline', ['input_element' => 'phone'])
            </div>
            <div class="py-2">
                <div class="float-right">@include('_parts.components.tooltip', ['tooltipText' => 'You will receive SMS alerts to your phone'])</div>
                <label class="block">
                    <input name="receive_sms" id="receive_sms" value="1" class="mr-1" type="checkbox" @if(old('receive_sms', 0) == 1) checked @endif> Receive text alerts
                </label>
            </div>
            <div class="py-4">
                <p class="text-sm text-center">By joining, you agree with our <a href="#" class="text-red underline hover:text-green">Terms and Conditions</a></p>
            </div>
        @endslot
        @slot('cardRoute')
            {{ route('signup') }}
        @endslot
        @slot('cardButtonValue')
            {{ __('Sign Up') }}
        @endslot
        @slot('cardUnderContent')
            <div class="p-8 text-center bg-grey-lighter border-top border-grey-light">
                Already a member?
                <a href="{{ route('login') }}" class="text-red underline hover:text-green">Sign in</a>
            </div>
        @endslot
    @endcomponent
@endsection



