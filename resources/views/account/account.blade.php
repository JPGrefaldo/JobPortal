@extends('layouts.page-2-col')


@section('page-content')
    @include('_parts.pages.page-title', ['pageTitle' => 'Account Settings'])

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
@endsection