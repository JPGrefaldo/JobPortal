@extends('layouts.default_layout')

@section('content')

    <div class="container">
        @include('_parts.pages.page-title', ['pageTitle' => $position->name])

        <div class="flex">
            {{-- sidecontent --}}
            <div class="w-1/4 text-grey py-md">
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
            <div>
                <div class="bg-white rounded flex-1 shadow-lg p-8 mb-4">
                    <div class="flex mb-4 items-center">
                        {{-- department --}}
                        <h2 class="flex-1">
                            Department: {{ $position->department->name }}
                        </h2>
                        {{-- apply or leave --}}
                        @if ($crew->hasPosition($position))
                            <button class="bg-red hover:bg-red-dark text-white font-bold py-2 px-4 rounded">
                                Leave
                            </button>
                        @else
                            <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded">
                                Apply
                            </button>
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

                <div class="bg-white rounded flex-1 shadow-lg p-8 mb-4">

                    @if ($crew->hasPosition($position))
                        <form class="w-full max-w-md">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="endorser_name_1">
                                        Endorser name
                                    </label>
                                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                                        id="endorser_name_1" type="text" placeholder="John Doe">
                                </div>
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="endorser_email_1">
                                        Last Name
                                    </label>
                                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                                        id="endorser_email_1" type="text" placeholder="joe@example.com">
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-3">
                                <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded align-baseline">
                                    Ask Endorsement
                                </button>
                            <div>
                        </form>
                    @endif
                </div>
            </div>
            {{-- main content end --}}

        </div>
    </div>
@endsection
