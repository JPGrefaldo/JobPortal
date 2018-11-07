@extends('layouts.default_layout')

@section('content')
    @include('_parts.pages.page-title', ['pageTitle' => 'Post your project'])
    <div class="flex">
        <div>
        <div>Tutorial Videos/How it Works</div>
            <div class="flex flex-col">
                Project title:
                <input type="text" name="title">
            </div>
            <div class="flex flex-col">
                Production company name (or your name if individual)
                <input type="text" name="production_name">
            </div>
            <div class="flex flex-col">
                Show my production company name publicly?
                <div>
                    <input type="radio" name="is_public" value="1" checked>Yes
                    <input type="radio" name="is_public" value="0">No
                </div>
            </div>
            <div class="flex flex-col">
                Project type:
                <select name="project_type" id="project_type">
                    @foreach ($projectTypes as $projectType)
                        <option value="{{ $projectType->id }}">{{ $projectType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col">
                Project information
                <textarea name="project_information" id="project_information"></textarea>
            </div>
            <div class="flex flex-col">
                City/Area:
                <input type="text">
            </div>
            <div class="flex flex-col mb-8">
                <h3>Positions needed</h3>
                @foreach ($departments as $department)
                    <input type="button" value="{{ $department->name }}">
                    @foreach ($department->positions as $position)
                        <div>
                            <input type="checkbox">
                            {{ $position->name }}
                        </div>
                        Pay rate:
                        <div>
                        $ <input type="text" name="pay_rate">
                            <input type="radio" value="hourly" name="pay_type_id"> Hourly
                            <input type="radio" value="daily" name="pay_type_id"> Daily
                            <input type="radio" value="half_day" name="pay_type_id"> Half day
                        </div>
                        - or -
                        <div>
                            <input type="radio" name="pay_type_id"> DOE
                            <input type="radio" name="pay_type_id"> TBD
                            <input type="radio" name="pay_type_id"> Unpaid/Volunteer
                        </div>
                        Production dates/dates needeed:
                        {{-- this should be some date picker that will return a string --}}
                        <input type="text">
                        Position notes:
                        <textarea name="notes" id=""></textarea>
                        <div>
                            <input type="checkbox" name="rush_call"> Rush Call? (interviews or works in the next 2-3 days?)
                        </div>
                    @endforeach
                @endforeach
            </div>
            <div class="flex flex-col">
                <h5>
                    Would you like to accept talent submission from other Castring Calls America sites?
                </h5>
                <div>
                    <input type="radio" selected> Yes
                    <input type="radio"> No
                    {{-- TODO: need to defer to producer uri instead of admin --}}
                    <a href="{{ route('admin.sites') }} ">See site list</a>
                </div>
            </div>
            <p>
                Only roles that accept video auditions and are padi, or audio auditions can be posted on ther sites.
            </p>
            <div class="flex flex-col">
                Sites to post on
                <div>
                    <input type="checkbox"> Check All
                </div>
                <div>
                    <input type="checkbox"> Yourcasting Test Site
                </div>
                    @foreach ($sites as $site)
                        <div>
                            <input type="checkbox"> {{ $site->name }}
                        </div>
                    @endforeach
            </div>
            <div>
                Will travel/lodging expenses be paid for out-of-area talent?
                <div>
                    <input type="radio"> Yes
                    <input type="radio"> No
                </div>
            </div>
        </div>
    </div>
@endsection
