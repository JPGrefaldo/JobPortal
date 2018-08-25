@component('account._parts.account-card')
    @slot('subtitle')
        Notifications
    @endslot

    @slot('accountContent')

    @endslot

    @slot('accountSaveURL')
        {{ route('account.notifications') }}
    @endslot
@endcomponent