@extends('layouts.page-1-col')
@section('page-content')
    <div class="container">
        <div class="w-full pb-8 border-b-2 mb-8 border-grey-light flex justify-between items-center">
            <h1 class="font-header text-blue-dark text-2xl font-semibold">Current Projects</h1>
        </div>
        <div class="w-3/4 mx-auto">
            <project-card v-for="project in {{$projects}}" :key="project.id" :project="project"/>
        </div>
    </div>
@endsection
