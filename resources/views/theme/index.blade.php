@extends('layouts.default_layout')

@section('content')
        <div class="container">
            @include('_parts.pages.page-title', ['pageTitle' => 'Theme Demo'])

            @include('theme.components.buttons')
            @include('theme.components.pills')

        </div>
@endsection