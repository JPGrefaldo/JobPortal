@extends('layouts.default_layout')

@section('content')
    <messages-dashboard :roles="{{ $roles }}" :projects="{{ $projects }}"></messages-dashboard>
@endsection
