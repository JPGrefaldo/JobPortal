@extends('layouts.default_layout')

@section('content')
    @include('_parts.pages.page-title', ['pageTitle' => 'Post your project'])
    <div class="flex">
        <div class="w-1/3">Left panel?</div>
        <div class="w-2/3 flex-col">
            <div>
                Project title:
                <input type="text">
            </div>
            <div>
                Production company name (or your name if individual)
                <input type="text">
            </div>
            <div>
                Show my production company name publicly?
                <input type="radio" id="is_public" value="Yes" selected="selected">
                <input type="radio" id="is_public" value="No">
            </div>
            <div>
                Project type:
                <select name="project_type" id="project_type">
                    @foreach ($projectTypes as $projectType)
                        <option value="{{ $projectType->id }}">{{ $projectType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                Project information
                <textarea name="project_information" id="project_information"></textarea>
            </div>
            <div>
                City/Area:
                <input type="text">
            </div>
            <div>
                Positions needed
                @foreach ($departments as $department)
                    <input type="button" value="{{ $department->name }}">
                    @foreach ($department->positions as $position)
                        <input type="checkbox">
                        {{ $position->name }}
                        Pay rate:
                        $ <input type="text">
                            <input type="radio" value="hourly">
                            <input type="radio" value="daily">
                            <input type="radio" value="half_day">
                        - or -
                        <input type="checkbox"> DOE
                        <input type="checkbox"> TBD
                        <input type="checkbox"> Unpaid/Volunteer
                        Producntion dates/dates needeed:
                        <input type="text">
                        Position notes:
                        <input type="text">
                        <input type="checkbox"> Rush Call? (interviews or works in the next 2-3 days?)
                    @endforeach
                @endforeach
                Would you like to accpet talent submission from other Castring Calls America sites?
                <input type="radio" selected> Yes
                <input type="radio"> No
                <a href="{{ route('admin.sites') }} ">See site list</a>
                Only roles that accept video auditions and are padi, or audio auditions can be posted on ther sites.

                Sites to post on
                <input type="checkbox">
                <input type="checkbox"> Yourcasting Test Site
                @foreach ($sites as $site)
                    <input type="checkbox">{{ $site->name }}
                @endforeach
                Will travel/lodgin expenses be paid for out-of-area talent?
                <input type="radio"> Yes
                <input type="radio"> No
            </div>
        </div>
    </div>
@endsection
