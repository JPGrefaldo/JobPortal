@extends('layouts.default_layout')

@section('content')
    <div class="container">
        @include('_parts.pages.page-title', [
            'pageTitle' => 'Endorsements',
        ])

        <div class="bg-white shadow-md rounded mb-8 border border-grey-light">
            <div class="p-8">
                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">
                    {{ str_plural('Endorsement', $total_endorsements) }}
                </h3>
            </div>
            <div class="bg-grey-lighter pb-2 px-2 border-t border-grey-light rounded-b">
                @if ($positions->count())
                    @foreach($positions as $position)
                        @include('crew.endorsement.__parts.endorsement-positions')
                    @endforeach
                @endif
            </div>
        </div>
    </div>

@endsection
