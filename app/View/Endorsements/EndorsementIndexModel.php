<?php

namespace App\View\Endorsements;


use App\Models\User;
use Spatie\ViewModels\ViewModel;

class EndorsementIndexModel extends ViewModel
{
    /**
     * @var User
     */
    public $user;
    /**
     * @var \Illuminate\Support\Collection
     */
    public $approvedEndorsementPositions;

    /**
     * EndorsementIndexModel constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        $this->loadUser();

        $this->approvedEndorsementPositions = $this->getApprovedEndorsementsPositions();
    }

    private function getApprovedEndorsementsPositions()
    {
        $endorsements = $this->user->crew->approvedEndorsements;

        if ($endorsements->count()) {
            return $this->buildEndorsementCollection($this->loadEndorsements($endorsements));
        }

        return collect([]);
    }

    private function loadUser()
    {
        $this->user->load([
            'crew',
            'crew.endorsements',
            'crew.approvedEndorsements',
        ]);
    }

    private function loadEndorsements($endorsements)
    {
        return $endorsements->load([
            'request',
            'request.crewPosition',
            'request.crewPosition.position',
        ]);
    }

    /**
     * @param $endorsements
     * @return \Illuminate\Support\Collection
     */
    private function buildEndorsementCollection($endorsements)
    {
        $ret = [];

        foreach ($endorsements as $endorsement) {
            $position = $endorsement->request->crewPosition->position;

            if (! isset($ret[$position->id])) {
                $ret[$position->id] = [
                    'position'    => $position,
                    'request'     => $endorsement->request,
                    'endorsement' => $endorsement,
                    'count' => 1,
                ];
            } else {
                $ret[$position->id]['count']++;
            }
        }

        return collect($ret);
    }
}