@extends('layouts.default_layout')

@section('content')
    @component('static-pages._parts.card')
        @slot('cardTitle')
            <h1 class="text-blue-dark text-center">ABOUT CREW</h1>
        @endslot

        @slot('cardContent')
        <div class="py-2">
            <h4 class="mt-8 uppercase text-sm  mt-10 text-blue-dark">What we do?</h4>
            <p class="leading-normal mt-3 text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
            It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker 
            including versions of Lorem Ipsum.</p>

            <h4 class="mt-8 uppercase text-sm  mt-10 text-blue-dark">Who are we?</h4>
            <p class="leading-normal mt-3 text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
            It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker 
            including versions of Lorem Ipsum.</p>

            <h4 class="mt-8 uppercase text-sm  mt-10 text-blue-dark">Why we're different?</h4>
            <p class="leading-normal mt-3 text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
            It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker 
            including versions of Lorem Ipsum.</p>
        </div>
        @endslot
    @endcomponent
@endsection
