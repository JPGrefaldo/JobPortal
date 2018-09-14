@extends('layouts.material_layout')


@section('content')

    <main class="float-left w-full px-3 py-md md:py-lg">
        <div class="container">
            @include('_parts.pages.page-title', ['pageTitle' => 'Account Settings'])

            @include('_parts.messagebox')

            @include('account._parts.account-menu', ['menu_items' => [
                    'account.name' => 'Name',
                    'account.contact' => 'Contact',
                    'account.subscription' => 'Subscription',
                    'account.password' => 'Password',
                    'account.manager' => 'Add Manager',
                    'account.notifications' => 'Notifications',
                    'account.close' => 'Close Account',
                ]
            ])

            @switch($accountType)
                @case('name')
                    @include('account._parts.cards.account-name')
                @break
                @case('contact')
                    @include('account._parts.cards.account-contact')
                @break
                @case('subscription')
                    @include('account._parts.cards.account-subscription')
                @break
                @case('password')
                    @include('account._parts.cards.account-password')
                @break
                @case('manager')
                    @include('account._parts.cards.account-manager')
                @break
                @case('notifications')
                    @include('account._parts.cards.account-notifications')
                @break
                @case('close')
                    @include('account._parts.cards.account-close')
                @break
            @endswitch
        </div>
    </main>
@endsection