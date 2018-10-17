@extends('layouts.default_layout')
@section('content')

<div class="container">
    @include('_parts.pages.page-title', ['pageTitle' => 'Edit endorsement request'])
    <edit-endorsement-form url="{{ route('endorsements.update',  $endorsementRequest) }}" comment="{{ $endorsement->comment }}"></edit-endorsement-form>
</div>
@endsection
