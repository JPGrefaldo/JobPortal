<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;

class DeleteCrewPositionGearPhoto
{
    /**
     * @param Crew $crew
     * @param Position $position
     * @return array
     */
    public function execute(Crew $crew, Position $position)
    {
        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();
        $crewGear = $crew->gears()->where('crew_position_id', $crewPosition->id)->first();

        if (! $crewGear) {
            return false;
        }

        Storage::disk('s3')->delete($crewGear->path);

        $crewGear->update([
            'path' => null,
        ]);

        return true;
    }
}
