<div class="sm-only:w-full w-1/2">
    <div class="bg-white mt-4 mr-1 rounded p-4 shadow">
        <div class="flex justify-between items-center">
            <h3 class="text-blue-dark font-semibold text-md mb-1 font-header">
                {{ $endorsement_position }}
            </h3>
        </div>

        <div class="flex items-center">
            <span class="pill-sm">Sent by {{ $from }}</span>
        </div>

        <div class="flex mb-2 pt-2 mt-2 border-t-2 border-grey-lighter justify-end">
            <form action="{{ route('crew.endorsement.delete', $id) }}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn-red">Delete</button>
            </form>
        </div>
    </div>
</div>
