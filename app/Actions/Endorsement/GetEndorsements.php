<?php

namespace App\Actions\Endorsement;

use App\Actions\Crew\GetCrewPositionByPosition;
use App\Models\Endorsement;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class GetEndorsements
{
    /**
     * @param User $user
     * @param Position $position
     * @param bool $approved
     * @return Collection
     */
    public function execute(User $user, Position $position, bool $approved = false): Collection
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
