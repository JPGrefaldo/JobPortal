@extends('layouts.page-2-col')

@section('page-content')

    @include('_parts.pages.page-title', ['pageTitle' => 'Edit profile'])

    @include('crew.profile.parts.profile-complete-indicator')

    <div class="md:w-3/4 float-left">
        <form action="{{ route('crew.profile.update') }}" method="post" enctype="multipart/form-data">
            <div class="card mb-8">
                <div class="w-full mb-6">
                    <h3 class="text-blue-dark font-semibold text-md md:text-lg mb-1 font-header">{{ $user->name }}</h3>
                </div>

                <div class="md:flex">
                  <div class="md:w-1/3 md:pr-6 mb-6">
                        @if (! empty($user->crew->photo_url))
                            <div class="flex h-none bg-grey-light items-center justify-center text-center border border-grey-light w-full pb-full rounded relative"
                                 style="background: url('{{ $user->crew->photo_url }}'); background-size: cover;">
                            </div>
                            <cca-delete-crew-profile-photo :crew="{{ $user->crew }}"></cca-delete-crew-profile-photo>
                        @else
                            <div class="flex h-none bg-grey-light items-center justify-center text-center border border-grey-light w-full pb-full rounded relative background-missing-avatar" >
                                <span class="text-center uppercase text-sm font-semibold text-white px-2 pos-center w-full">
                                    <label class="inline-block text-black">UPLOAD PROFILE PHOTO</label>
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
                            <h3 class="section-title mb-2 md:mb-0">Profile Photo</h3>
                        </div>
                        <div class="w-full md:w-2/3">
                            <file-pond></file-pond>
                            @if (isset($user->crew->photo_path))
                                <div class="w-full pt-2">
                                    <p class="text-sm text-grey">
                                        {{ basename($user->crew->photo_path) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="border-t-2 border-grey-lighter py-4">
                    <div class="md:flex">
                        <div class="md:w-1/3 pr-8">
                            <h3 class="section-title mb-2 md:mb-0">General resume</h3>
                        </div>
                        <div class="md:w-2/3">
                            <label for="resume" class="btn-outline text-green inline-block mb-4">
                                {{ isset($resume) ? 'Update file' : 'Upload file' }}
                            </label>
                            <p class="text-sm text-grey">
                                <a href="{{ $resume }}" target="_blank">{{ basename($resume) }}</a>
                            </p>
                            <input id="resume"
                                   type="file"
                                   name="resume"
                                   class="hidden">
                        </div>
                    </div>
                </div>

                <div class="border-t-2 border-grey-lighter py-4">
                    <div class="md:flex">
                        <div class="md:w-1/3 pr-8">
                            <h3 class="section-title mt-2 mb-2 md:mb-0">General reel</h3>
                        </div>
                        <div class="md:w-2/3">
                            <label for="reel_file" class="btn-outline text-green inline-block mb-4">
                                {{ isset($reel->path) ? 'Update file' : 'Upload file' }}
                            </label>

                            <input id="reel_file"
                                   type="file"
                                   name="reel_file"
                                   class="hidden">
                            or
                            <input type="text"
                                   name="reel_link"
                                   class="form-control bg-light md:w-2/3 mr-2 mb-2 md:mb-0 w-full"
                                   placeholder="Add link"
                                   value="{{ old('reel_link', (isset($user->crew) ? $user->crew->getGeneralReelLink() : '')) }}">
                        </div>
                    </div>
                </div>

                <div class="border-t-2 border-grey-lighter py-4">
                    <div class="md:flex">
                        <div class="md:w-1/3 pr-8">
                            <h3 class="section-title mt-2 mb-4 md:mb-2">Social profiles</h3>
                        </div>
                        <div class="md:w-2/3">
                           @if($socialLinkTypes)
                                @foreach($socialLinkTypes as $key => $socialLinkType)
                                    <div class="flex flex-wrap items-stretch w-full mb-2 relative">
                                        <div class="flex -mr-px">
                                            <span class="flex w-10 items-center leading-normal rounded rounded-r-none px-2 whitespace-no-wrap text-grey-dark" style="background: url('/{{ $socialLinkType->image}}'); background-size: cover;"></span>
                                        </div>
                                        <input type="text"
                                               id="{{$socialLinkType->id}}"
                                               class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-l-none px-3 relative"
                                               placeholder="Add {{$socialLinkType->name}} link"
                                               name="socials[{{ $socialLinkType->slug }}][url]"
                                               value="{{ @old('socials.'. $socialLinkType->slug .'.url', $socialLinkType->toArray()['crew'][0]['url']) }}"  >
                                        <input type="hidden" name="socials[{{ $socialLinkType->slug }}][id]" value="{{ $socialLinkType->id }}">
                                    </div>
                                @endforeach
                           @endif
                        </div>
                    </div>
                </div>
                <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                    <input type="submit" class="btn-green" value="SAVE CHANGES">
                </div>
            </div>

            @if(Auth::user()->crew) @method('PUT') @endif

            @csrf
        </form>

        <div class="py-4">
            <h4 class="card-title">WORK POSITIONS</h4>
        </div>

        <cca-department-component :departments="{{ $departments }}"/>
    </div>

@endsection
