@extends('layouts.default_layout')

@section('content')
        <div class="container">
            @include('_parts.pages.page-title', ['pageTitle' => 'Theme Demo'])
            <div class="bg-white shadow-md rounded mb-8 border border-grey-light">
                <div class="p-8">
                    <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">
                        Buttons
                    </h3>
                </div>
                <div class="bg-grey-lighter pb-8 px-8 border-t border-grey-light rounded-b">
                    <div class="bg-white mt-4 rounded p-4 md:p-8 shadow">
                        <h3 class="text-blue-dark mb-1 font-header">Outline</h3>
                        <button class="btn-blue-outline">.btn-blue-outline</button>
                        <button class="btn-green-outline">.btn-green-outline</button>
                        <button class="btn-red-outline">.btn-red-outline</button>
                        <button class="btn-yellow-outline">.btn-yellow-outline</button>
                        <span class="bg-blue py-2 px-4">
                            <button class="btn-white-outline">.btn-white-outline</button>
                        </span>
                    </div>
                    <div class="bg-white mt-4 rounded p-4 md:p-8 shadow">
                        <h3 class="text-blue-dark mb-1 font-header">Rounded</h3>
                        <button class="btn-blue">.btn-blue</button>
                        <button class="btn-green">.btn-green</button>
                        <button class="btn-red">.btn-red</button>
                        <button class="btn-yellow">.btn-yellow</button>
                        <span class="bg-blue py-4 px-8">
                            <button class="btn-white">.btn-white</button>
                        </span>
                    </div>
                    <div class="bg-white mt-4 rounded p-4 md:p-8 shadow">
                        <h3 class="text-blue-dark mb-1 font-header">Rounded - Small</h3>
                        <button class="btn-blue-small">.btn-blue-small</button>
                        <button class="btn-green-small">.btn-green-small</button>
                        <button class="btn-red-small">.btn-red-small</button>
                        <button class="btn-yellow-small">.btn-yellow-small</button>
                        <span class="bg-blue py-2 px-4">
                            <button class="btn-white-small">.btn-white-small</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
@endsection