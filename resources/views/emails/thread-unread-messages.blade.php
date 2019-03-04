@component('mail::message')
#Hello {{ $user->first_name }},

<p>You have new messages in your thread as follows:</p>

@foreach ($messages as $message)
<p><strong>{{ $message->thread }}</strong></p>
<p>{{ $message->body }}</p>
<small>Time Sent: <strong>{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</strong></small>
@endforeach

@component('mail::button', ['url' => $url])
View Messages
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
