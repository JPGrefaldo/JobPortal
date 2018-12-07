<div class="bg-white mt-4 rounded p-4  shadow">
    <div class="flex justify-between items-center">
        <h3 class="text-blue-dark font-semibold text-md mb-1 font-header">
            {{ $position->name }}
        </h3>
    </div>
    <div class="flex items-center">
        @if (isset($endorsements[$position->id]['approved']) && $endorsements[$position->id]['approved'] > 0)
            <span class="pill-blue pill-sm">@if (isset($endorsements[$position->id]['approved'])) {{ $endorsements[$position->id]['approved'] }} @else 0 @endif Endorsed</span>
        @endif
        @if (isset($endorsements[$position->id]['unapproved']) && $endorsements[$position->id]['unapproved'] > 0)
            <span class="pill-yellow pill-sm ml-1">@if (isset($endorsements[$position->id]['unapproved'])) {{ $endorsements[$position->id]['unapproved'] }} @else 0 @endif  Pending</span>
        @endif
    </div>

    <div class="flex mb-2 pt-2 mt-2 border-t-2 border-grey-lighter justify-end">
        <a href="{{ route('crew.endorsement.position.show', [$position->id]) }}"
           class="btn-green"
        >
            <span class=""><svg class="fill-current w-4 h-4 mr-2" viewBox="0 0 20 20"><path d="M2 6H0v2h2v2h2V8h2V6H4V4H2v2zm7 0a3 3 0 0 1 6 0v2a3 3 0 0 1-6 0V6zm11 9.14A15.93 15.93 0 0 0 12 13c-2.91 0-5.65.78-8 2.14V18h16v-2.86z"/></svg>Get Endorsement</span>
        </a>
    </div>
</div>