<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\Position;
use App\Models\CrewPosition;

class DeleteCrewPosition
{
    /**
     * @param \App\Models\Crew $crew
     * @param \App\Models\Position $position
     * @return array
     */
    public function execute(Crew $crew, Position $position)
    {
        return CrewPosition::byCrewAndPosition($crew, $position)->delete() ? 'success' : 'failed';
    }
}