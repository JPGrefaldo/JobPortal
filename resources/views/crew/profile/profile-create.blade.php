@extends('layouts.default_layout')

@section('content')

    <main class="float-left w-full px-3 py-md md:py-lg">
        <div class="container">

            @include('_parts.pages.page-title', ['pageTitle' => 'Edit profile'])

            @include('_parts.messagebox')

            @include('crew.profile.parts.profile-complete-indicator')

            <div class="md:w-3/4 float-left">
                <form action="{{ route('profile') }}" method="post">
                    <div class="card mb-8">
                        <div class="w-full mb-6">
                            <h3 class="text-blue-dark font-semibold text-md md:text-lg mb-1 font-header">{{ $user->full_name }}</h3>
                        </div>

                        <div class="md:flex">
                            <div class="md:w-1/3 md:pr-6 mb-6">
                                <div class="flex h-none bg-grey-light items-center justify-center cursor-pointer text-center border border-grey-light w-full pb-full rounded relative background-missing-avatar">
                                    <span class="text-center uppercase text-sm font-semibold text-black px-2 pos-center w-full">UPLOAD PROFILE PHOTO</span>
                                </div>
                            </div>

                            <div class="md:w-2/3">
                                <div class="p-3 md:p-6 bg-grey-lighter rounded">
                                    <div class="mb-2">
                                        <label for="" class="block mb-3">Biography</label>
                                        <textarea class="form-control w-full h-64" placeholder="Biography" name="bio">{{ old('bio', (isset($user->crew) ? $user->crew->bio : '')) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t-2 border-grey-lighter mt-6 py-4">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <h3 class="text-md font-header mb-2 md:mb-0">Profile Photo</h3>
                                </div>
                                <div class="md:w-2/3">
                                    <a href="#" class="btn-outline inline-block">Upload file</a>
                                </div>
                            </div>
                        </div>

                        <div class="border-t-2 border-grey-lighter py-4">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <h3 class="text-md font-header mb-2 md:mb-0">General resume</h3>
                                </div>
                                <div class="md:w-2/3">
                                    <a href="#" class="btn-outline inline-block">Upload file</a>
                                </div>
                            </div>
                        </div>

                        <div class="border-t-2 border-grey-lighter py-4">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <h3 class="text-md font-header mt-2 mb-2 md:mb-0">General reel</h3>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="form-control bg-light w-64 mr-2 mb-2 md:mb-0" placeholder="Add link"><div> or <a href="#" class="btn-outline inline-block">Upload file</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="border-t-2 border-grey-lighter py-4">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <h3 class="text-md font-header mt-2 mb-2 md:mb-0">Social profiles</h3>
                                </div>
                                <div class="md:w-2/3">
                                    <div class="flex flex-wrap items-stretch w-full mb-2 relative">
                                        <div class="flex -mr-px">
                                            <span class="flex w-10 items-center leading-normal bg-yellow-imdb rounded rounded-r-none px-2 whitespace-no-wrap text-grey-dark"><i class="fab fa-imdb text-lg mr-0 text-white inline-block"></i></span>
                                        </div>
                                        <input type="text" class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-l-none px-3 relative" placeholder="Add IMDb link">
                                    </div>
                                    <div class="flex flex-wrap items-stretch w-full mb-2 relative">
                                        <div class="flex -mr-px">
                                            <span class="flex w-10 items-center leading-normal bg-blue-linkedin rounded rounded-r-none px-2 whitespace-no-wrap text-grey-dark"><i class="fab fa-linkedin-in text-lg mr-0 text-white"></i></span>
                                        </div>
                                        <input type="text" class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-l-none px-3 relative" placeholder="Add LinkedIn link">
                                    </div>
                                    <div class="flex flex-wrap items-stretch w-full mb-2 relative">
                                        <div class="flex -mr-px">
                                            <span class="flex w-10 text-center items-center leading-normal bg-blue-facebook rounded rounded-r-none px-2 whitespace-no-wrap text-grey-dark"><i class="fab fa-facebook-f text-lg mr-0 text-white inline-block"></i></span>
                                        </div>
                                        <input type="text" class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-l-none px-3 relative" placeholder="Add Facebook link">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                            <a href="#" class="text-grey bold mr-4 hover:text-green">Cancel</a>
                            <input type="submit" class="btn-green" value="SAVE CHANGES">
                        </div>
                    </div>

                    @csrf
                </form>

                <div class="py-4">
                    <h4 class='text-grey'>WORK POSITIONS</h4>
                </div>
                <div class="card mb-6">
                    <div class="md:flex justify-between">
                        <h3 class="text-blue-dark font-semibold text-lg font-header mb-3 md:mb-0">Production</h3>
                        <a href="#" class="btn-green-outline">ADD POSITION</a>
                    </div>
                </div>

                <div class="card mb-6">
                    <div class="pb-6">
                        <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Camera</h3>
                    </div>
                    <div class="p-4 bg-grey-lighter">
                        <div class="py-2">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-6 mb-3 md:mb-1">
                                    <label class="checkbox-control"><h3 class="text-md">Camera operator</h3>
                                        <input type="checkbox" checked="checked"/>
                                        <div class="control-indicator"></div>
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <textarea class="form-control w-full h-32" placeholder="Biography"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="py-2">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-2 md:mb-0">General resume</span>
                                </div>
                                <div class="md:w-2/3">
                                    <a href="#" class="btn-outline inline-block">Upload file</a>
                                </div>
                            </div>
                        </div>
                        <div class="py-2">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-2 md:mb-0">General reel</span>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="form-control bg-light w-64 mr-2 mb-3 md:mb-0" placeholder="Add link"> or <a href="#" class="btn-outline inline-block">Upload file</a>
                                </div>
                            </div>
                        </div>
                        <div class="py-2">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <span class="font-bold font-header text-blue-dark mt-2 block md:text-right">Gear</span>
                                </div>
                                <div class="md:w-2/3">
                                    <div class="pb-4">
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="form-slider"></span>
                                        </label>
                                    </div>
                                    <label for="" class="block mb-3">What gear do you have for this position?</label>
                                    <textarea class="form-control w-full h-32" placeholder="Your gear"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 md:p-4 border-t-2 border-grey-lighter bg-white">
                        <div class="py-2">
                            <label class="checkbox-control"><h3 class="text-md">Camera Visual Effects</h3>
                                <input type="checkbox"/>
                                <div class="control-indicator"></div>
                            </label>
                        </div>
                    </div>
                    <div class="p-2 md:p-4 border-t-2 border-grey-lighter bg-white">
                        <div class="py-2">
                            <label class="checkbox-control"><h3 class="text-md">Camera Visual Effects</h3>
                                <input type="checkbox"/>
                                <div class="control-indicator"></div>
                            </label>
                        </div>
                    </div>
                    <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                        <a href="#" class="text-grey bold mr-4 hover:text-green">Cancel</a>
                        <a href="#" class="btn-green">SAVE CHANGES</a>
                    </div>

                </div>
                <div class="card mb-6">
                    <div class="md:flex justify-between">
                        <h3 class="text-blue-dark font-semibold text-lg font-header mb-2 md:mb-0">Sound</h3>
                        <a href="#" class="btn-green-outline">ADD POSITION</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection