@component('mail::message')

# {{ $project->title }} {{ $message }}

@component('mail::button', ['url' => route('admin.projects')])
Approve
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent