@extends('layouts.default_layout')

@section('content')
    @include('_parts.pages.page-title', ['pageTitle' => 'Post your project'])
   
    <cca-producer-projects-create />
@endsection
