<div class="bg-white mt-4 rounded p-4 md:p-8 shadow">
    <div class="flex justify-between items-center">
        <h3 class="text-blue-dark font-semibold text-md mb-1 font-header">
            {{ $position->name }}
        </h3>
    </div>

    <div class="md:flex mb-4 pt-6 mt-6 border-t-2 border-grey-lighter items-center justify-end">
        @if ($endorsementPositions[$position->id]['approved'])
            <a href="{{ route('crew.endorsement.position.show', [$position->id]) }}" class="flex justify-between mt-4 md:mt-0 block btn-outline bg-green text-white">
                <span class="pt-1">View {{ str_plural('Endorse', $endorsementPositions[$position->id]['approved']) }}</span> <span class="ml-4 badge badge-white">{{ $endorsementPositions[$position->id]['approved'] }}</span>
            </a>
        @endif
            @if ($endorsementPositions[$position->id]['unapproved'])
            <a href="#" class="flex mt-4 md:mt-0 block btn-outline bg-green text-white ml-2">
                <span class="pt-1">View Pending {{ str_plural('Endorsement', $endorsementPositions[$position->id]['unapproved']) }}</span> <span class="ml-4 badge badge-white">{{ $endorsementPositions[$position->id]['unapproved'] }}</span>
            </a>
        @endif
    </div>
</div>