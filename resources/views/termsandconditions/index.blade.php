
@extends('layouts.default_layout')

@section('content')
<div class="container max-w-xl flex justify-center items-center">
        <div class="bg-white shadow-md rounded">
            <div class="p-8">
                <h2 class="font-header text-blue-dark text-lg text-center font-semibold">Terms and Conditions</h2>
                <div class="py-2">
                    <p class="leading-normal mt-10 text-justify text-blue-dark">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                    It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
                    It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker 
                    including versions of Lorem Ipsum.</p>

                    <p class="leading-normal mt-10 text-justify text-blue-dark">Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                    It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                    It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker 
                    including versions of Lorem Ipsum.</p>

                    <p class="leading-normal mt-10 text-justify text-blue-dark">Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                    It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
                    It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker 
                    including versions of Lorem Ipsum.</p>
                </div>
            </div>
            <div class="p-8 text-right bg-grey-lighter border-top border-grey-light">
                <a href="{{ url()->previous() }}" class="btn-green">OK</a>
            </div>
        </div>
</div>
@endsection

