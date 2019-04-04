@component('mail::message')

# {{ $project->title }} is added.

@component('mail::button', ['url' => route('admin.projects.approve', $project->id)])
Approve
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent