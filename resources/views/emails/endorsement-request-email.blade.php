{{-- TODO: update message, make it look like the app is talking to the endorser --}}
@component('mail::message')
# Endorsement request from a friend.

Hi

Can you endorse me for [{{ $endorsement->request->position }}]({{ route('crew.endorsement.position.show', $endorsement) }}) on CrewCallsAmerica.com?
This will help me get future jobs on the site.

{{-- @component('mail::button', ['url' => route('endorsements.create', $endorsement->request)])
Sure Bud, I'll endorse you.
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
