@component('mail::message')
# Message Flagged

@component('mail::panel')
    {{ $message->body }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
