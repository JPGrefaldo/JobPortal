@extends('layouts.page-2-col')

@section('page-content')
    @include('_parts.pages.page-title', ['pageTitle' => 'Jobs'])
    <cca-crew-projects class="container" :jobs="{{$jobs}}"></cca-crew-projects>
@endsection