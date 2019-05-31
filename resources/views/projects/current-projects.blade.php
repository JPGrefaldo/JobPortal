@extends('layouts.page-2-col')

@section('page-content')
    @include('_parts.pages.page-title', ['pageTitle' => 'Current Projects'])

    <div class="w-1/4 float-left pr-8 py-md hidden md:block">
        <h4 class="text-grey mb-4">PROJECT TIPS</h4>
        <p>Complete projects have a better chance of being selected and show up higher in search results. </p>
        <div class="py-lg">
            <h4 class="text-grey mb-4">HOW IT WORKS VIDEO</h4>
            <a href="#" class="pb-66 h-none rounded relative block" style="background: url(/images/th2.jpg); background-size:cover;">
                <span class="btn-play w-10 h-10"></span>
            </a>
        </div>
        <div>
            <h4 class="text-grey leading-loose">Need help?<br> <a href="#" class="text-green">Contact support</a></h4>
        </div>
    </div>
    <cca-crew-current-projects :projects="{{$projects}}"></cca-crew-current-projects>
    @if(!$projects->count())
    <div class="md:w-3/4 float-left">
        <div class="bg-white shadow-md rounded mb-8 border border-grey-light">
            <div class="p-8">
                <div class="w-full mb-6 flex justify-between">
                    <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Sorry, No Project Available</h3>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
