<?php

namespace App\Actions\Crew;


use App\Models\CrewPosition;
use Cache;

class GetCrewPositionByPosition
{
    /**
     * @param $user
     * @param $position
     * @return \App\Models\CrewPosition
     */
    public function execute($user, $position)
    {
        return CrewPosition::wherePositionId($position->id)
            ->whereCrewId($user->crew->id)
            ->firstOrFail();
    }
}