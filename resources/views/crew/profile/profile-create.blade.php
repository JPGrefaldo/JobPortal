@extends('layouts.default_layout')

@section('content')

    <main class="float-left w-full px-3 py-md md:py-lg">
        <div class="container">

            @include('_parts.pages.page-title', ['pageTitle' => 'Edit profile'])

            @include('_parts.messagebox')

            @include('crew.profile.parts.profile-complete-indicator')

            <div class="md:w-3/4 float-left">
                <form action="{{ route('profile') }}" method="post" enctype="multipart/form-data">
                    <div class="card mb-8">
                        <div class="w-full mb-6">
                            <h3 class="text-blue-dark font-semibold text-md md:text-lg mb-1 font-header">{{ $user->full_name }}</h3>
                        </div>

                        <div class="md:flex">
                          <div class="md:w-1/3 md:pr-6 mb-6">
                                
                                @if (isset($user->crew->photo))
                                <div class="flex h-none bg-grey-light items-center justify-center text-center border border-grey-light w-full pb-full rounded relative" style="background: url(/storage/{{ $user->crew->photo }}); background-size: cover;">
                                </div>
                                @else 
                                <div class="flex h-none bg-grey-light items-center justify-center cursor-pointer text-center border border-grey-light w-full pb-full rounded relative background-missing-avatar" >
                                    <span class="text-center uppercase text-sm font-semibold text-white px-2 pos-center w-full">
                                    
                                    <label for="photo-file" class="inline-block text-black cursor-pointer">UPLOAD PROFILE PHOTO</label>
                                    <input type="file" name="photo" id="photo-file" class="invisible"></input>
                                    </span>
                                </div>
                                @endif
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
                                    <label for="photo-file" class="btn-outline text-green inline-block" >Upload file</label>
                                    <input type="file" name="photo" id="photo-file" class="invisible"></input>
                                </div>
                            </div>
                        </div>

                        <div class="border-t-2 border-grey-lighter py-4">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <h3 class="text-md font-header mb-2 md:mb-0">General resume</h3>
                                </div>
                                <div class="md:w-2/3">
                                    <label for="resume-file" class="btn-outline text-green inline-block" >Upload file</label>
                                    <input type="file" name="resume_file" id="resume-file" class="invisible"></input>
                                </div>
                            </div>
                        </div>

                        <div class="border-t-2 border-grey-lighter py-4">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <h3 class="text-md font-header mt-2 mb-2 md:mb-0">General reel</h3>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" name="reel_link" class="form-control bg-light w-64 mr-2 mb-2 md:mb-0" placeholder="Add link"><div>
                                </div>
                            </div>
                        </div>
                        <div class="border-t-2 border-grey-lighter py-4">
                            <div class="md:flex">
                                <div class="md:w-1/3 pr-8">
                                    <h3 class="text-md font-header mt-2 mb-2 md:mb-0">Social profiles</h3>
                                </div>
                                   <div class="md:w-2/3">  
                                        @foreach($socialLinkTypes as $key => $socialLinkType)
                                        <div class="flex flex-wrap items-stretch w-full mb-2 relative">

                                            <div class="flex -mr-px">
                                                <span class="flex w-10 items-center leading-normal rounded rounded-r-none px-2 whitespace-no-wrap text-grey-dark" style="background: url(/{{ $socialLinkType->image}}); background-size: cover;"></span>
                                            </div>
                                            <input type="text" id="{{$socialLinkType->id}}" class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-l-none px-3 relative" placeholder="Add {{$socialLinkType->name}} link" name="socials[{{$socialLinkType->id}}]" value="{{isset($socialLinkType->crew[0])? $socialLinkType->crew[0]->url :'' }}" ></input>
                                        </div>
                                        @endforeach
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
<!--                 @foreach($departments as $key => $department)
                <div class="card mb-6">
                    <div class="md:flex justify-between">
                        <h3 class="text-blue-dark font-semibold text-lg font-header mb-3 md:mb-0">{{$department->name}}</h3>
                        <a href="#" class="btn-green-outline">ADD POSITION</a>
                    </div>
                </div>
                @endforeach -->

                @foreach($departments as $key => $department)
                <div class="card mb-6">
                    <div class="pb-6">
                        <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">{{$department->name}}</h3>
                    </div>      
                    @foreach($department->positions as $key => $position)
                    <div class="p-2 md:p-4 border-t-2 border-grey-lighter bg-white">
                        <div class="py-2">
                            <label class="checkbox-control"><h3 class="text-md">{{$position->name}}</h3>
                                <input type="checkbox"/>
                                <div class="control-indicator"></div>
                            </label>
                        </div>
                    </div>
                    @endforeach
                    <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                        <a href="#" class="text-grey bold mr-4 hover:text-green">Cancel</a>
                        <a href="#" class="btn-green">SAVE CHANGES</a>
                    </div>          
                </div>
                @endforeach
            </div>
        </div>
    </main>

@endsection