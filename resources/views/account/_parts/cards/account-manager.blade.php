@component('account._parts.account-card')
    @slot('subtitle')
        Add Manager
    @endslot

    @slot('accountContent')

    @endslot

    @slot('accountSaveURL')
        {{ route('account.manager') }}
    @endslot
@endcomponent