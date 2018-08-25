@component('account._parts.account-card')
    @slot('subtitle')
        Notifications
    @endslot

    @slot('accountContent')
        <div>
            <h4 class="mt-6 uppercase text-sm text-blue-dark">Email Address</h4>
            <input class="w-full border border-light-grey max-w-sm p-4 my-4"
                   type="text"
                   name="email"
                   value="{{ old('email', $user->email) }}"
                   placeholder="Email Address">
        </div>
        <div>
            <h4 class="mt-4 uppercase text-sm text-blue-dark">Email Address Confirmation</h4>
            <input class="w-full border border-light-grey max-w-sm p-4 my-4"
                   type="text"
                   name="email_confirmation"
                   value="{{ old('email_confirmation', $user->email) }}"
                   placeholder="Email Address">
        </div>

        <div>
            <h4 class="mt-6 uppercase text-sm text-blue-dark">Phone Number</h4>
            <input class="w-full border border-light-grey max-w-sm p-4 my-4"
                   type="text"
                   name="phone"
                   value="{{ \App\Utils\StrUtils::formatPhone(old('phone', $user->phone)) }}"
                   placeholder="Phone Number">
        </div>
    @endslot

    @slot('accountSaveURL')
        {{ route('account.contact') }}
    @endslot
@endcomponent