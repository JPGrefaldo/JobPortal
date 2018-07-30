@component('mail::message')
# Endorsement request from a friend.

Hi {{ $endorsement->endorser_name }}

Can you endorse me for [{{ $endorsement->position->name }}]({{ route('crew_position.show', [
    'position' => $endorsement->position,
]) }}) on CrewCallsAmerica.com?
This will help me get future jobs on the site.

@component('mail::button', ['url' => route('endorsement.create', ['endorsementRequest' => $endorsement->request->token])])
Sure Bud, I'll endorse you.
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
