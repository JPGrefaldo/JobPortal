@component('account._parts.account-card')
    @slot('subtitle')
        Add Manager
    @endslot

    @slot('accountContent')
    <input name="email" placeholder="Email Address of the manager" 
           value="{{ isset($manager->email) ? $manager->email : old('email') }}"/>
    @endslot

    @slot('accountSaveURL')
        {{ route('account.manager') }}
    @endslot
@endcomponent