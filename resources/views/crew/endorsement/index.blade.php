@extends('layouts.default_layout')

@section('content')
    <div class="container">
        @include('_parts.pages.page-title', [
            'pageTitle' => 'Endorsements',
            'button' => [
                'link' => '#',
                'text' => 'New Endorsement',
            ],
        ])

        <div class="bg-white shadow-md rounded mb-8 border border-grey-light">
            <div class="p-8">
                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Current Endorsements <span class="badge">{{ Auth::user()->crew->endorsements->count() }}</span></h3>
            </div>
            <div class="bg-grey-lighter pb-8 px-8 border-t border-grey-light rounded-b">
                @foreach ($positions as $position)

                    <div class="flex justify-between mb-2 rounded bg-grey-light shadow h-16 items-center px-2">
                        <a class="" href="{{ route('crew.endorsement.position.show', $position) }}">{{ $position->name }}</a>
                        <div class="flex items-center">
                            <div class="mr-2">Endorsers: {{ auth()->user()->crew->endorsements->count() }}</div>
                            @if (auth()->user()->crew->hasPosition($position))
                                {{-- TODO --}}
                                <a class="inline-block border border-red rounded py-2 px-4 bg-red hover:bg-red-dark text-white" href="#">
                                    Leave
                                </a>
                            @else
                                <a class="inline-block border border-blue rounded py-2 px-4 bg-blue hover:bg-blue-dark text-white" href="{{ route('crew.endorsement.position.create', $position) }}">
                                    Apply
                                </a>
                            @endif
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>

@endsection
