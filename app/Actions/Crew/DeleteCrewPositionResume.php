<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;

class DeleteCrewPositionResume
{
    /**
     * @param \App\Models\Crew $crew
     * @param \App\Models\Position $position
     * @return array
     */
    public function execute(Crew $crew, Position $position)
    {
        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        if ($crewPosition->resume == null)
            return;

        return response()->json([
            'message' => $crewPosition->resume->delete() ? 'success' : 'failed',
        ]);
    }
}