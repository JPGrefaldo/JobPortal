@extends('layouts.default_layout')

@section('content')
<cca-project-job-submissions :job="{{ $job }}" :project="{{ $project }}"/>
@endsection