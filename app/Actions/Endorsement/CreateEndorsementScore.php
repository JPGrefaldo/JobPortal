<?php

namespace App\Actions\Endorsement;

use App\Models\CrewEndorsementScoreSweetener;
use App\Models\CrewPosition;
use App\Models\CrewPositionEndorsementScore;
use App\Models\Endorsement;
use Cache;

class CreateEndorsementScore
{
    /**
     * Calculate the users endorsement score
     *  Per position
     *      Every endorsement equals 1+# of endorsements of endorsers / total # of endorsers +1
     *      If user has a sweetener add it to the number of endorsements of endorsers
     *
     * @param \App\Models\CrewPosition $crewPosition
     * @return float
     */
    public function execute(CrewPosition $crewPosition): float
    {
        $score = $this->calculateScore($crewPosition);

        CrewPositionEndorsementScore::updateOrCreate([
            'crew_position_id' => $crewPosition->id,
        ], [
            'score' => $score,
        ]);

        return $score;
    }

    /**
     * @param $endorsements
     * @param $crewPosition
     * @return int
     */
    public function getEndorsersEndorsementCount($endorsements, $crewPosition)
    {
        $endorsementCount = 0;
        foreach ($endorsements as $endorsement) {
            $crewID = $endorsement->endorser->user->crew->id;

            $endorsementCount += $this->getSweetener($crewID);

            $endorserCrewPosition = CrewPosition::whereCrewId($crewID)
                ->wherePositionId($crewPosition->position_id)
                ->firstOrFail();

            $endorsementCount += Endorsement::whereCrewPositionId($endorserCrewPosition->id)
                ->count();
        }

        return $endorsementCount;
    }

    /**
     * @param int $crewID
     * @return mixed
     */
    public function getSweetener($crewID)
    {
        if ($sweetener = CrewEndorsementScoreSweetener::whereCrewId($crewID)
            ->first()
        ) {
            return $sweetener->sweetener;
        }

        return 0;
    }

    /**
     * @param \App\Models\CrewPosition $crewPosition
     * @return float|int
     */
    public function calculateScore(CrewPosition $crewPosition)
    {
        $endorsements = Endorsement::whereCrewPositionId($crewPosition->id)
            ->approved()
            ->with([
                'endorser',
                'endorser.user',
                'endorser.user.crew',
            ])
            ->get();

        return ($this->getEndorsersEndorsementCount($endorsements, $crewPosition) + 1) /
            ($endorsements->count() + 1);
    }
}
