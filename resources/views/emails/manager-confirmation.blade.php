@component('mail::message')
# Hello {{$manager->first_name}},
<br>
{{$subordinate->full_name}} added you as manager.

@component('mail::button', ['url' => url('/account/manager/confirm/' . $manager->id)])
Accept
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
