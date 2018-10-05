@extends('layouts.default_layout')

@section('content')
    <div class="container">
        @include('_parts.pages.page-title', ['pageTitle' => 'Positions'])
        @foreach ($positions as $position)

            <div class="flex justify-between mb-2 rounded bg-grey-light shadow h-16 items-center px-2">
                <a class="" href="{{ route('crew_position.show', $position) }}">{{ $position->name }}</a>
                <div class="flex items-center">
                    <div class="mr-2">Endorsers: {{ auth()->user()->crew->endorsements->count() }}</div>
                    @if (auth()->user()->crew->hasPosition($position))
                        <a class="inline-block border border-red rounded py-2 px-4 bg-red hover:bg-red-dark text-white" href="#">
                            Leave
                        </a>
                    @else
                        <a class="inline-block border border-blue rounded py-2 px-4 bg-blue hover:bg-blue-dark text-white" href="{{ route('crew_position.create', $position) }}">
                            Apply
                        </a>
                    @endif
                </div>
            </div>

        @endforeach
    </div>

@endsection
