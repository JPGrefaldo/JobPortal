@extends('layouts.default_layout')
@section('content')

<div class="container">
    @include('_parts.pages.page-title', ['pageTitle' => "Apply for $position->name"])
    <edit-crew-position-form url={{ route('crew_position.store', $position) }} details={{ CrewPosition::byCrewAndPosition($crew, $position) }} union_description="{{ CrewPosition::byCrewAndPosition($crew, $position) }}"></edit-crew-position-form>
</div>
@endsection
