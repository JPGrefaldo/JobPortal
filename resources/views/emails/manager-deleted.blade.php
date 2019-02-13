@component('mail::message')
#Hello {{$manager->first_name}},

You are being removed as manager by {{$subordinate->fullname}}.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
