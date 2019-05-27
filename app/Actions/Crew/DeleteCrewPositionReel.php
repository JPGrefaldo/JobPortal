<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;

class DeleteCrewPositionReel
{
    /**
     * @param \App\Models\Crew $crew
     * @param \App\Models\Position $position
     * @return array
     */
    public function execute(Crew $crew, Position $position)
    {
        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();
        $crewReel     = $crew->reels()->where('crew_position_id', $crewPosition->id)->first();

        if (! $crewReel) {
            return false;
        }

        Storage::disk('s3')->delete($crewReel->path);

        $crewReel->delete();

        return true;
    }
}
