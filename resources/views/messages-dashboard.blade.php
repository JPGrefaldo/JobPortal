@extends('layouts.default_layout')

@section('content')
    <messages-dashboard :roles="{{ $roles }}"></messages-dashboard>
@endsection
