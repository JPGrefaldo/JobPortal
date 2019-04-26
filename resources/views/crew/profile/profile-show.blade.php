@extends('layouts.default_layout')

@section('content')
    <main class="float-left w-full py-md md:py-lg px-3">
        <div class="container">
            <div class="w-full float-left">
                <div class="card float-left md:flex mb-8 w-full">
                    <div class="md:w-1/4 md:pr-8 text-center">
                        <img src="images/thumb.jpg" class="rounded" alt="" />
                        <ul class="list-reset py-4">
                            <li class="py-1">
                                <a href="#" class="flex items-center">
                                    <div class="p-1 rounded bg-yellow-imdb w-8 h-8"><img src="images/imdb.svg" alt="" class="mr-2 img-responsive"></div><span class="ml-2 text-yellow-imdb">IMDb profile</span></a>
                            </li>
                            <li class="py-1">
                                <a href="#" class="flex items-center text-blue-linkedin">
                                    <img src="images/linkedin.svg" alt="" class="mr-2">LinkedIn profile</a>
                            </li>
                        </ul>
                    </div>
                    <div class="md:w-3/4">
                        <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">{{ $user->first_name }} {{ $user->last_name }}</h3>
                        <span class="text-grey font-semibold font-header">{{ Auth::user()->position }}</span>
                        <div class="bg-grey-lighter p-6 rounded my-8">
                            <p>
                                @if (isset($user->crew))
                                    {{ $user->crew->bio }} 
                                @endif 
                                <a href="#" class="text-sm text-grey tracking-wide">Read more</a>
                            </p>
                        </div>
                        <div class="pb-2 md:flex">
                                <a href="#" class="border md:w-1/2 flex overflow-hidden rounded md:mr-2 mb-2 md:mb-0">
                                    <div class="w-24 relative" style="background: url(images/th2.jpg); background-size: cover;">
                                        <span class="btn-play w-10 h-10"></span>
                                    </div>
                                    <span class='uppercase text-green font-semibold p-4 text-sm tracking-wide'>VIEW POSITION WORK REEL</span>
                                </a>
                                <a href="#" class="border md:w-1/2 flex items-center overflow-hidden rounded md:ml-2">
                                    <i class="far fa-file-alt px-6 text-lg"></i>
                                    <span class='uppercase text-green font-semibold px-0 py-6 text-sm tracking-wide'>VIEW POSITION RESUME</span>
                                </a>
                            </div>
                    </div>
                </div>
                <div class="py-4">
                    <h4 class='text-grey'>WORK POSITIONS</h4>
                </div>
                @foreach($crewPositions as $crewPosition)
                    @if($user->crew->hasPosition($crewPositions[0]))
                        <div class="card mb-6">
                            <div class="pb-6">
                                <span class="btn-toggle float-right"></span>
                                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">{{ $crewPosition->department->name }}
                                    <span class="font-thin"> – {{ $crewPosition->name }}</span>
                                </h3>
                            </div>
                            <div class="md:flex">
                                <div class="md:w-1/4 pr-8 mb-2 md:mb-0">
                                    <h3 class="text-md text-grey font-header">Position bio</h3>
                                </div>
                                <div class="md:w-3/4">
                                    <div class="bg-grey-lighter p-6 rounded mb-8">
                                        <p>{{ $crewPosition->pivot->details }}</p>
                                    </div>
                                    <div class="pb-2 md:flex">
                                        <a href="#" class="border md:w-1/2 flex overflow-hidden rounded md:mr-2 mb-2 md:mb-0">
                                            <div class="w-24 relative" style="background: url(images/th2.jpg); background-size: cover;">
                                                <span class="btn-play w-10 h-10"></span>
                                            </div>
                                            <span class='uppercase text-green font-semibold p-4 text-sm tracking-wide'>VIEW POSITION WORK REEL</span>
                                        </a>
                                        <a href="#" class="border md:w-1/2 flex items-center overflow-hidden rounded md:ml-2">
                                            <i class="far fa-file-alt px-6 text-lg"></i>
                                            <span class='uppercase text-green font-semibold px-0 py-6 text-sm tracking-wide'>VIEW POSITION RESUME</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="border-t-2 border-grey-lighter mt-4 pt-6 pb-4">
                                <div class="md:flex">
                                    <div class="md:w-1/4 md:pr-8 mb-2 md:mb-0">
                                        <h3 class="text-md text-grey font-header">Gear</h3>
                                    </div>
                                    <div class="md:w-3/4">
                                        <div class="bg-grey-lighter p-6 rounded">
                                            {{--@foreach( $crewPosition->crew->gears->where('crew_position_id',$crewPosition->position_id) as $gear )--}}
                                                {{--<p>{{ $gear->description }}</p>--}}
                                            {{--@endforeach--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </main>
@endsection
