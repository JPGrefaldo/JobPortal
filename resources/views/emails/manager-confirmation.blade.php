@component('mail::message')
# Someone added you as manager.

TODO: The body of your message.

@component('mail::button', ['url' => ''])
Accept
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
