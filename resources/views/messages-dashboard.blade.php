@extends('layouts.default_layout')

@section('content')
    {{-- TODO: need to defer roles as a global component --}}
    {{-- maybe have some global parent component that has roles attribute? --}}
    <messages-dashboard :roles="{{ $roles }}"
                        :projects="{{ $projects }}" />
@endsection
