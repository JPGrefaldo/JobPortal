@extends('layouts.default_layout')

@section('content')
    <div class="container">
        @include('_parts.pages.page-title', [
            'pageTitle' => 'Endorsements',
            'button' => [
                'link' => '#',
                'text' => 'New Endorsement Request',
            ],
        ])

        <div class="bg-white shadow-md rounded mb-8 border border-grey-light">
            <div class="p-8">
                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">
                    {{ str_plural('Endorsement', $endorsementPositions->count()) }} <span class="badge">{{ $endorsementPositions->count() }}</span>
                </h3>
            </div>
            <div class="bg-grey-lighter pb-8 px-8 border-t border-grey-light rounded-b">
                @if ($endorsementPositions->count())
                    @foreach($endorsementPositions as $position)
                        @include('crew.endorsement.__parts.endorsement-positions')
                    @endforeach
                @else
                    <div class="bg-white mt-4 rounded p-4 md:p-8 shadow">
                        <div class="flex justify-between items-center">
                            <h3 class="text-blue-dark font-semibold text-md mb-1 font-header">
                                No current endoresements
                            </h3>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
