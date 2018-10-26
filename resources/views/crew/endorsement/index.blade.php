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
                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">
                    Current Endorsements <span class="badge">{{ $approvedEndorsementPositions->count() }}</span>
                </h3>
            </div>
            <div class="bg-grey-lighter pb-8 px-8 border-t border-grey-light rounded-b">
                @foreach($approvedEndorsementPositions as $position)
                    @include('crew.endorsement.__parts.endorsement-positions')
                @endforeach
            </div>
        </div>
    </div>

@endsection
