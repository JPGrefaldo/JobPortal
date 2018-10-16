@extends('layouts.default_layout')

@section('content')

    <div class="container">
        @include('_parts.pages.page-title', ['pageTitle' => $position->name])

        <div class="flex">
            {{-- sidecontent --}}
            <div class="w-1/4 text-grey mr-4">
                <div class="mb-lg">
                    <h4 class="mb-4">
                        JOB TIPS
                    </h4>
                    <p>
                        The more people you get to endorse you, the higher chance of you being selected for a job.
                    </p>
                </div>
                <div class="mb-lg">
                    <h4 class="mb-4">
                        HOW IT WORKS VIDEO
                    </h4>
                    <div class=""></div>
                    <a href="#">video</a>
                </div>
                <div>
                    <h4 class="mb-4">
                        Need help?
                    </h4>
                    <a href="">Contact Support</a>
                </div>
            </div>

            {{-- main content --}}
            <div class="w-3/4">
                <div class="bg-white rounded flex-1 shadow-lg p-8 mb-4">
                    <div class="flex mb-4 items-center">
                        {{-- department --}}
                        <h2 class="flex-1">
                            Department: {{ $position->department->name }}
                        </h2>
                        {{-- apply or leave --}}
                        @if ($crew->hasPosition($position))
                            {{-- TODO --}}
                            <a class="inline-block border border-blue rounded py-2 px-4 bg-blue hover:bg-blue-dark text-white" href="{{ route('crew_position.create', $position) }}">
                                Leave
                            </a>
                        @else
                            <a class="inline-block border border-blue rounded py-2 px-4 bg-blue hover:bg-blue-dark text-white" href="{{ route('crew_position.create', $position) }}">
                                Apply
                            </a>
                        @endif
                    </div>

                    {{-- if crew has gear display it --}}
                    {{-- TODO: create test --}}
                    @if ($crew->gears->count())
                        <div class="mb-4">
                            {{ $crew->gears }}
                        </div>
                    @endif

                    {{-- if crew has union for position display it --}}
                    {{-- TODO: create test --}}
                    @if ($crew->hasPosition($position))
                        <div class="mb-4">
                            Union Description: {{ App\Models\CrewPosition::byCrewAndPosition($crew, $position)->first()->union_description }}
                        </div>
                    @endif

                    {{-- IDK this has many --}}

                    @if ($crew->hasPosition($position))
                        {{-- details --}}
                        <div class="mb-4">
                            Details: {{ App\Models\CrewPosition::byCrewAndPosition($crew, $position)->first()->details }}
                        </div>
                    @endif
                </div>

                @if ($crew->hasPosition($position))
                <div>
                    <create-endorsement-request-form url="{{ route('endorsement_requests.store', $position) }}"></create-endorsement-request-form>
                </div>
                @endif

                {{-- TODO --}}
                @if ($crew->endorsements()->exists())
                    more than one endorser
                @endif
            </div>
            {{-- main content end --}}

        </div>
    </div>
@endsection
