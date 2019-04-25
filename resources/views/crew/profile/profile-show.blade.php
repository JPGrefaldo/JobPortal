@extends('layouts.default_layout')

@section('content')
	<main class="float-left w-full px-3 py-md md:py-lg">
        <div class="container">
            <div class="w-full md:w-3/4 float-left">
            	{{ $user->name }} 's Profile
            	<div class="card md:flex mb-8">
            		<div class="md:w-1/4 md:pr-8 text-center">
            			@if (isset($user->crew->photo_path) && !empty($user->crew->photo_path))
                            <div class="flex h-none bg-grey-light items-center justify-center text-center border border-grey-light w-full pb-full rounded relative"
                                style="background: url('{{ $user->crew->photo_url }}'); background-size: cover;">
                            </div>
                        @else
                            <img src="{{ url('photos/avatar.png') }}"
                            class="rounded"
                            alt="Avatar" />
                        @endif
            		</div>
            	</div>
            </div>
        </div>
    </main>
@endsection
