@component('account._parts.account-card')
    @slot('subtitle')
        Subscription
    @endslot

    @slot('accountContent')

    @endslot

    @slot('accountSaveURL')
        {{ route('account.subscription') }}
    @endslot
@endcomponent