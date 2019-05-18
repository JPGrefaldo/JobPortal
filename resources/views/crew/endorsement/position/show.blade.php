@extends('layouts.default_layout')

@section('content')

    <div class="container">
        @include('_parts.pages.page-title', ['pageTitle' => $position->name])

        <div class="-md:flex-wrap-reverse md:flex -md:flex">
            {{-- sidecontent --}}
            <div class="block md:w-1/4 text-grey mr-4 -md:w-full less-than-large-padding-rl-1 -md:mb-1">
                <div class="mb-lg">
                    <h4 class="mb-4">
                        TIPS
                    </h4>
                    <p>
                        The more people you get to endorse you, the higher chance of you being selected for a job.
                    </p>
                </div>
                <div class="mb-lg">
                    <h4 class="mb-4">
                        HOW IT WORKS
                    </h4>
                    <a href="#">Video</a>
                </div>
                <div>
                    <h4 class="mb-4">
                        Need help?
                    </h4>
                    <a href="">Contact Support</a>
                </div>
            </div>

            {{-- main content --}}
            <div class="md:w-3/4 less-than-large-padding-rl-1 -md:w-full">
                <create-endorsement-request-form
                    position="{{ $position->name }}"
                    full_name="{{ $user->nickname_or_full_name }}"
                    url="{{ route('crew.endorsement.position.store', [$position->id]) }}"
                ></create-endorsement-request-form>

                @if ($approvedEndorsements->count())
                    <div class="bg-white rounded flex-1 shadow-lg p-8 mb-4">
                        <div class="w-100 border-b-2">
                            <h3 class="text-blue-dark font-semibold text-md md:text-lg mb-1 font-header">Endorsed</h3>
                        </div>
                        <endorsers-component
                                position="{{ $position->id }}"
                                type="approved_endorsements"
                        ></endorsers-component>
                    </div>
                @endif

                @if ($pendingEndorsements->count())
                    <div class="bg-white rounded flex-1 shadow-lg p-8 mb-4">
                        <div class="w-100 border-b-2">
                            <h3 class="text-blue-dark font-semibold text-md md:text-lg mb-1 font-header">Pending Endorsements</h3>
                        </div>
                        <endorsers-component
                                position="{{ $position->id }}"
                                type="pending_endorsements"
                        ></endorsers-component>
                    </div>
                @endif
            </div>
            {{-- main content end --}}

        </div>
    </div>
@endsection
