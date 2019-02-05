@component('account._parts.account-card')
    @slot('subtitle')
        Name
    @endslot

    @slot('accountContent')
        <div>
            <h4 class="mt-6 uppercase text-sm text-blue-dark">First Name</h4>
            <input class="w-full border border-light-grey max-w-sm p-4 my-4"
                   type="text"
                   name="first_name"
                   value="{{ old('first_name', $user->first_name) }}"
                   placeholder="First name">
        </div>
        <div>
            <h4 class="mt-2 uppercase text-sm text-blue-dark">Last Name</h4>
            <input class="w-full border border-light-grey max-w-sm p-4 my-4"
                   type="text"
                   name="last_name"
                   value="{{ old('last_name', $user->last_name) }}"
                   placeholder="Last name">
        </div>
        <div>
            <h4 class="mt-2 uppercase text-sm text-blue-dark">Nickname</h4>
            <input class="w-full border border-light-grey max-w-sm p-4 my-4"
                   type="text"
                   name="nickname"
                   value="{{ old('nickname', $user->nickname_or_full_name) }}"
                   placeholder="Last name">
        </div>
    @endslot

    @slot('accountSaveURL')
        {{ route('account.name') }}
    @endslot
@endcomponent