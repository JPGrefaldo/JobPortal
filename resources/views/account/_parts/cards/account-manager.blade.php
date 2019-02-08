@component('account._parts.account-card')
    @slot('subtitle')
        Add Manager
    @endslot

    @slot('accountContent')
    <div class="inline-flex">
        <input class="w-full border border-light-grey max-w-sm p-4 my-4" name="email" placeholder="Email Address of the manager" 
            value="{{ isset($manager->email) ? $manager->email : old('email') }}"/>
        <a href="#" id="removeManager" data-id="{{! isset($manager->id) ?: $manager->id}}" data-token="{{csrf_token()}}" class="bg-red-light hover:bg-grey text-red font-bold max-w-sm p-4 my-4 rounded-r">
            Remove
        </a>
    </div>
    @endslot

    @if (isset($manager->email))
        
    @endif

    @slot('accountSaveURL')
        {{ route('account.manager') }}
    @endslot
@endcomponent