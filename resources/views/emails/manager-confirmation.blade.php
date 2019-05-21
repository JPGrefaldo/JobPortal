@component('mail::message')
# Hello {{$manager->first_name}},
<br>
{{ $subordinate->name }} added you as manager.

@component('mail::button', [
    'url' => route('manager.confirm', [
            'user' => $manager->hash_id,
            'subordinate' =>$subordinate->hash_id
        ])
])
Accept
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
