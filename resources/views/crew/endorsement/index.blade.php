@extends('layouts.page-1-col')

@section('page-content')
        @include('_parts.pages.page-title', [
            'pageTitle' => 'Endorsements',
        ])

        <div class="bg-white shadow-md rounded mb-8 border border-grey-light">
            <div class="p-8">
                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">
                    {{ Str::plural('Endorsement', $total_endorsements) }}
                </h3>
            </div>
            <div class="bg-grey-lighter pb-2 px-2 border-t border-grey-light rounded-b flex flex-wrap">
                @if ($positions->count())
                    @foreach($positions as $position)
                        @include('crew.endorsement.__parts.endorsement-positions', [
                            'approvedEndorsements'   => isset($endorsements[$position->id]['approved']) ? $endorsements[$position->id]['approved'] : 0,
                            'unapprovedEndorsements' => isset($endorsements[$position->id]['unapproved']) ? $endorsements[$position->id]['unapproved'] : 0,
                        ])
                    @endforeach
                @endif
            </div>
        </div>

        <div class="bg-white shadow-md rounded mb-8 border border-grey-light">
            <div class="p-8">
                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">
                    {{ Str::plural('Pending Endorsement', $pending_endorsements->count()) }}
                </h3>
            </div>
            <div class="bg-grey-lighter pb-2 px-2 border-t border-grey-light rounded-b flex flex-wrap">
                @if ($pending_endorsements->count())
                    @foreach ($pending_endorsements as $pending_endorsement)
                        @include('crew.endorsement.__parts.pending-endorsements', [
                            'endorsement_position' => $pending_endorsement->request->endorsement->crewPosition->position->name,
                            'from'                 => $pending_endorsement->owner->email
                        ])
                    @endforeach
                @endif
            </div>
        </div>

@endsection
