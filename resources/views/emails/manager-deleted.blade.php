@component('mail::message')
#Hello {{$manager->first_name}},

You are being remove as manager by {{$subordinate->fullname}}.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
