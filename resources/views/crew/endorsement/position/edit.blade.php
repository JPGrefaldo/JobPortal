@extends('layouts.default_layout')
@section('content')

<div class="container">
    @include('_parts.pages.page-title', ['pageTitle' => "Edit $position->name position"])
    <edit-crew-position-form
        url="{{ route( 'crew.endorsement.position.update', $position) }}"
        details="{{ App\Models\CrewPosition::byCrewAndPosition($crew, $position)->first()->details }}"
        union_description="{{ App\Models\CrewPosition::byCrewAndPosition($crew, $position)->first()->union_description }}">
    </edit-crew-position-form>
</div>
@endsection
