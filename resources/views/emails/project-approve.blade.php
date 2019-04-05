@component('mail::message')

# {{ $project->title }} is added.

@component('mail::button', ['url' => route('admin.projects')])
Approve
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent