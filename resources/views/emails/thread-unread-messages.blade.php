@component('mail::message')
#Hello {{$user->first_name}},

<p>You have new messages in your thread as follows:</p>

@foreach ($messages as $msg)
@foreach ($msg as $item)
<p><strong>{{$item->thread}}</strong></p>
<p>{{$item->body}}</p>
<small>Time Sent: <strong>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</strong></small>
@endforeach
@endforeach

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
