@component('mail::message')
# Hi {{ $crew->nickname }},

Add new experience to your resume. Apply now!
<hr>
@component('mail::panel')
## [{{ $projectJob->position_name }}]({{ route('crew.project.vacancy', $projectJob->id) }})
@if (isset($projectJob->pay_rate) && $projectJob->pay_rate != 0)
Salary: $ {{ $projectJob->pay_rate }}.00 / {{ $projectJob->pay_type }}
@else
Pay Type: {{ $projectJob->pay_type }}
@endif
<br>
Persons Needed: {{ $projectJob->persons_needed }}
<br>
Dates Needed:
@if (is_array($projectJob->dates_needed))
@foreach ($projectJob->dates_needed as $date)
+ {{ $date }}
@endforeach
@else
{{ $projectJob->dates_needed }}
@endif 
@endcomponent
@component('mail::button', ['url' => route('admin.projects')])
Apply
@endcomponent

<hr>
This e-mail has been automatically generated. If you wish to contact us, please click on [{{ config('app.name') }}]({{ route('home') }})
@endcomponent
