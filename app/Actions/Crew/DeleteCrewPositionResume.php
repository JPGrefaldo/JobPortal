<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;

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

        $crewResume = $crew->resumes()->where('crew_position_id', $crewPosition->id)->first();
        
        if($crewResume) {
            Storage::disk('s3')->delete($crewResume->path);

            return response()->json([
                'message' => $crewResume->delete() ? 'success' : 'failed',
            ]);
        } else {
            return response()->json([
                'message' => 'failed',
            ]);
        }
    }
}
