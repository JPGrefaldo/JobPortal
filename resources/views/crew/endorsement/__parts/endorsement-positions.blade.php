<div class="sm-only:w-full w-1/2">
    <div class="bg-white mt-4 mr-1 rounded p-4 shadow">
        <div class="flex justify-between items-center">
            <h3 class="text-blue-dark font-semibold text-md mb-1 font-header">
                {{ $position->name }}
            </h3>
            <p>Score: {{ $endorsement_score }}</p>
        </div>

        <div class="flex items-center h-6">
            <p class="text-grey-100 mr-2">Status:</p>
            @if ($approvedEndorsements > 0)
                <span class="pill-blue pill-sm">{{ $approvedEndorsements }} Endorsed</span>
            @endif
            @if ($unapprovedEndorsements > 0)
                <span class="pill-yellow pill-sm ml-1">{{ $unapprovedEndorsements }} Pending</span>
            @endif
            @if ($approvedEndorsements == 0 && $unapprovedEndorsements == 0)
                <span class="pill-red pill-sm ml-1">None</span>
            @endif
        </div>
        <div class="flex mb-2 pt-2 mt-2 border-t-2 border-grey-lighter justify-end">
            <a href="{{ route('crew.endorsement.position.show', [$position->id]) }}"
               class="btn-green"
            >
                <span>
                    <svg class="fill-current w-4 h-4 mr-2" viewBox="0 0 20 20">
                        <path
                            d="M2 6H0v2h2v2h2V8h2V6H4V4H2v2zm7 0a3 3 0 0 1 6 0v2a3 3 0 0 1-6 0V6zm11 9.14A15.93 15.93 0 0 0 12 13c-2.91 0-5.65.78-8 2.14V18h16v-2.86z"
                        />
                    </svg>
                    Get Endorsement
                </span>
            </a>
        </div>
    </div>
</div>
