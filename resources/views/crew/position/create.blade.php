@extends('layouts.default_layout')
@section('content')

<div class="container">
    @include('_parts.pages.page-title', ['pageTitle' => "Apply for $position->name"])
    <create-crew-position-form></create-crew-position-form>
</div>
@endsection
