@extends('layouts.default_layout')

@section('content')
    @include('_parts.pages.page-title', ['pageTitle' => 'Post your project'])
    <div class="flex">
        <div class="w-1/3">Left panel?</div>
        <div class="w-2/3">
            Main conten
            Project title:
            Production company name (or your name if individual)
            Show my production company name publicly?
            Project type:
        </div>
    </div>
@endsection
