@component('mail::message')
# Hello {{$manager->first_name}},
<br>
{{$subordinate->full_name}} added you as manager.

@component('mail::button', [
    'url' => url('/confirm/' . $manager->hash_id . '/' . $subordinate->hash_id)
])
Accept
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
