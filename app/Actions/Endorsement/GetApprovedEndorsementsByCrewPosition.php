<?php

namespace App\Actions\Endorsement;

use App\Models\CrewPosition;
use App\Models\Endorsement;

class GetApprovedEndorsementsByCrewPosition
{
    /**
     * @param \App\Models\CrewPosition $crewPosition
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function execute(CrewPosition $crewPosition): \Illuminate\Database\Eloquent\Collection
    {
        return Endorsement::whereCrewPositionId($crewPosition->id)
            ->approved()
            ->get();
    }
}
