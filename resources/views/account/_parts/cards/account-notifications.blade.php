@component('account._parts.account-card')
    @slot('subtitle')
        Notifications
    @endslot

    @slot('accountContent')
        <div>
            <h4 class="mt-4 uppercase text-sm text-blue-dark">
                Receive Email @include('_parts.componets.tooltip', ['tooltipText' => 'Receive email notifications of new jobs'])
            </h4>
            @include('_parts.input.switch', [
                'switchOn' => $user->notificationSettings->receive_email_notification,
                'switchName' => 'receive_email_notification',
                'switchValue' => (int)$user->notificationSettings->receive_email_notification,
            ])
        </div>

        <div>
            <h4 class="mt-4 uppercase text-sm text-blue-dark">Receive Other Email</h4>
            @include('_parts.input.switch', [
                'switchOn' => $user->notificationSettings->receive_other_emails,
                'switchName' => 'receive_other_emails',
                'switchValue' => (int)$user->notificationSettings->receive_other_emails,
            ])
        </div>
        <div>
            <h4 class="mt-4 uppercase text-sm text-blue-dark">Receive Text Messages</h4>
            @include('_parts.input.switch', [
                'switchOn' => $user->notificationSettings->receive_sms,
                'switchName' => 'receive_sms',
                'switchValue' => (int)$user->notificationSettings->receive_sms,
            ])
        </div>
    @endslot

    @slot('accountSaveURL')
        {{ route('account.notifications') }}
    @endslot
@endcomponent