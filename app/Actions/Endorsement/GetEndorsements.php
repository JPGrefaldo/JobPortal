<?php

namespace App\Actions\Endorsement;

use App\Actions\Crew\GetCrewPositionByPosition;
use App\Models\Endorsement;

class GetEndorsements
{
    public function execute($user, $position, $approved = false)
    {
        $crewPosition = app(GetCrewPositionByPosition::class)->execute($user, $position);

        $endorsements = Endorsement::with([
            'request',
            'request.endorser',
            'request.endorser.user',
        ])->whereCrewPositionId($crewPosition->id);

        if ($approved) {
            $endorsements->whereNotNull('approved_at');
        }

        return $endorsements->get();
    }
}
