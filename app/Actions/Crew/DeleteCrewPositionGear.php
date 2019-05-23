<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;

class DeleteCrewPositionGear
{
    /**
     * @param \App\Models\Crew $crew
     * @param \App\Models\Position $position
     * @return array
     */
    public function execute(Crew $crew, Position $position)
    {
        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        $crewGear = $crew->gears()->where('crew_position_id', $crewPosition->id)->first();

        if ($crewGear) {
            Storage::disk('s3')->delete($crewGear->path);
            
            $crewGear->update([
                'path' => '',
            ]);

            return response()->json([
                'message' => 'success',
            ]);
        } else {
            return response()->json([
                'message' => 'failed',
            ]);
        }
    }
}
