@extends('layouts.default_layout')

@section('content')
    <cca-crew-projects class=" ml-6 mr-6" :jobs="{{$jobs}}"></cca-crew-projects>
@endsection