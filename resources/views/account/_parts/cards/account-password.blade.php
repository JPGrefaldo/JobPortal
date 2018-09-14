@component('account._parts.account-card')
    @slot('subtitle')
        Change Password
    @endslot

    @slot('accountContent')
        <div>
            <h4 class="mt-6 uppercase text-sm text-blue-dark">Current Password</h4>
            <input class="w-full border border-light-grey max-w-sm p-4 my-4"
                   type="password"
                   name="current_password">
        </div>
        <div>
            <h4 class="mt-2 uppercase text-sm text-blue-dark">New Password</h4>
            <input class="w-full border border-light-grey max-w-sm p-4 my-4"
                   type="password"
                   name="password">
        </div>
        <div>
            <h4 class="mt-2 uppercase text-sm text-blue-dark">Confirm Password</h4>
            <input class="w-full border border-light-grey max-w-sm p-4 my-4"
                   type="password"
                   name="password_confirmation">
        </div>
    @endslot

    @slot('accountSaveURL')
        {{ route('account.password') }}
    @endslot
@endcomponent