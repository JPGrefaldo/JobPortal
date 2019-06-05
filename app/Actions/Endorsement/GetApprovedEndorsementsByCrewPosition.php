<?php

namespace App\Actions\Endorsement;

use App\Models\CrewPosition;
use App\Models\Endorsement;
use Illuminate\Database\Eloquent\Collection;

class GetApprovedEndorsementsByCrewPosition
{
    /**
     * @param CrewPosition $crewPosition
     * @return Collection
     */
    public function execute(CrewPosition $crewPosition): Collection
    {
        return Endorsement::whereCrewPositionId($crewPosition->id)
            ->approved()
            ->get();
    }
}
