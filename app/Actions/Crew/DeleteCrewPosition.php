<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\Position;

class DeleteCrewPosition
{
    /**
     * @param \App\Models\Crew $crew
     * @param \App\Models\Position $position
     * @return array
     */
    public function execute(Crew $crew, Position $position)
    {
        return $crew->crewPositions()->where('position_id', $position->id)->delete() ? 'success' : 'failed'; 
    }
}