<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;

class DeleteCrewPosition
{
    /**
     * @param Crew $crew
     * @param Position $position
     * @return array
     */
    public function execute(Crew $crew, Position $position)
    {
        return CrewPosition::byCrewAndPosition($crew, $position)->delete() ? 'success' : 'failed';
    }
}
