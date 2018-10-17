@extends('layouts.default_layout')
@section('content')

<div class="container">
    @include('_parts.pages.page-title', ['pageTitle' => 'Approve endorsement request'])
    <create-endorsement-form
        url="{{ route( 'endorsements.store', $endorsementRequest) }}"
        endorsee_name="{{ $endorseeName }}"
        position="{{ $position }}">
    </create-endorsement-form>
</div>
@endsection
