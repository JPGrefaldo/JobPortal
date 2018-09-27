@extends('layouts.default_layout')

@section('content')

    <div class="container">
        @include('_parts.pages.page-title', ['pageTitle' => $position->name])

        {{-- sidecontent --}}
        <div class="w-1/4 float-left pr-8 py-md hidden md:block">
            <h4 class="text-grey mb-4">
                JOB TIPS
            </h4>
            <p>
                The more people you get to endorse you, the higher chance of you being selected for a job.
            </p>
            <div class="py-lg">
                <h4 class="text-grey mb-4">
                    HOW IT WORKS VIDEO
                </h4>
                <a class="pb-66 h-none rounded relative block" href="#" style="background: url(images/th2.jpg); background-size:cover;">
                    <span class="btn-play w-10 h-10">
                    </span>
                </a>
            </div>
            <div>
                <h4 class="text-grey leading-loose">
                    Need help?<br>
                    <a class="text-green" href="#">Contact support</a>
                </h4>
            </div>
        </div>

        {{-- main content --}}
        <div class="md:w-3/4 float-left">
            <div class="card mb-8">
                <div class="w-full mb-6">
                    <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">
                        Job details
                    </h3>
                </div>
                @if (auth()->user()->crew->hasPosition($position))
                    <div class="md:flex py-3">
                        <div class="md:w-1/3 pr-6">
                            <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">
                                Ask for an endorsement.
                            </span>
                        </div>
                        <div class="md:w-2/3 pr-6">
                                <form action="{{ route('endorsement_requests.store', ['position' => $position]) }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="md:flex">
                                        <div class="md:w-1/2">
                                            <input class="form-control w-full" name="endorsers[0][name]" placeholder="Endorser's name." type="text">
                                        </div>
                                        <div class="md:w-1/2">
                                            <input class="form-control w-full" name="endorsers[0][email]" placeholder="Endorser's email." type="text">
                                        </div>
                                        <input dusk="ask_endorsement" type="submit" value="Ask Endorsement">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="md:flex py-3">
                        <div class="md:w-1/3 pr-6">
                            <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">
                                <form action="{{ route('crew_position.store', $position) }}" method="post">
                                    {{ csrf_field() }}
                                    <button type="submit">Apply</button>
                                </form>
                            </span>
                        </div>
                        <div class="md:w-2/3 pr-6">
                            </div>
                        </div>
                    </div>
                @endif
        </div>
    </div>
@endsection
