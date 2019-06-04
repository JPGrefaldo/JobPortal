<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;

class DeleteCrewPositionResume
{
    /**
     * @param Crew $crew
     * @param Position $position
     * @return array
     */
    public function execute(Crew $crew, Position $position)
    {
        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();
        $crewResume = $crew->resumes()->where('crew_position_id', $crewPosition->id)->first();

        if (! $crewResume) {
            return false;
        }

        Storage::disk('s3')->delete($crewResume->path);

        $crewResume->delete();

        return true;
    }
}
