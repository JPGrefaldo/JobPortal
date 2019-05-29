@extends('layouts.default_layout')

@section('content')

<div class="max-w-screen-xl flex justify-center items-center">
    <div class="overflow-hidden shadow-lg border-t-4 bg-white mb-4 rounded-b-lg rounded-t border-red-light w-full md:w-1/2 xl:w-1/3">
        <div class="px-6 py-4 mb-2 mt-4 mb-8">
            @if(Auth::user()->hasRole(\App\Models\Role::CREW))
                <div class="uppercase tracking-wide text-c2 mb-4">
                    @if (!(Auth::user()->crew->hasSubscription()))
                    Crew
                    <a href="{{ route('account.subscription') }}" class="float-right">Subscribe</a>
                    @endif
                </div>
                <div class="flex border px-4 py-2 text-lg border-b-0">
                    <div class="pl-2">
                        <a href="{{ route('crew.profile.index') }}">View Profile</a>
                    </div>
                </div>
                <div class="flex border px-4 py-2 text-lg border-b-0">
                    <div class="pl-2">
                        <a href={{ route('crew.profile.edit') }}>Edit Profile</a>
                    </div>
                </div>
                <div class="flex border px-4 py-2 text-lg">
                    <div class="pl-2">
                        <a href={{ route('crew.endorsement.index') }}>Endorsements</a>
                    </div>
                </div>
            @endif

            @if(Auth::user()->hasRole(\App\Models\Role::PRODUCER))
                <div class="uppercase tracking-wide text-c2 mb-4 mt-8">
                    Producer
                </div>
                <div class="flex border px-4 py-2 text-lg">
                    <div class="pl-2">
                        <a href={{ route('producer.projects.create') }}>Create Position</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
