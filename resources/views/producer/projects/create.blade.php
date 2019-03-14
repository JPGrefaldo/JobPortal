@extends('layouts.default_layout')

@section('content')
    <main class="float-left w-full px-3 py-md md:py-lg">
        <div class="container">
            @include('_parts.pages.page-title', ['pageTitle' => 'Post your project'])

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
   
            <cca-producer-projects-create />
        </div>
    </main>
@endsection
