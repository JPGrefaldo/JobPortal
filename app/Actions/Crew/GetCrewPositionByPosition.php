<?php

namespace App\Actions\Crew;

use App\Models\CrewPosition;
use App\Models\Position;
use App\Models\User;

class GetCrewPositionByPosition
{
    /**
     * @param User $user
     * @param Position $position
     * @return \App\Models\CrewPosition
     */
    public function execute(User $user, Position $position): CrewPosition
    {
        return CrewPosition::wherePositionId($position->id)
            ->whereCrewId($user->crew->id)
            ->firstOrFail();
    }
}
