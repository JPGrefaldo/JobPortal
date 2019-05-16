@extends('layouts.page-1-col')

@section('page-content')
        <div class="container">
            @include('_parts.pages.page-title', ['pageTitle' => 'Theme Demo'])

            @include('theme.components.buttons')
            @include('theme.components.pills')

        </div>
@endsection