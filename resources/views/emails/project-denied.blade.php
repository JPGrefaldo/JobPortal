@component('mail::message')
Hello {{ $producer->first_name }},

@component('mail::panel')
# Project Denied

Your {{ $project->title }} project has been denied. Due to {{$project->deniedReason->body}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
