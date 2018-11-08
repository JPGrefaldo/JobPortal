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
    public $endorsementPositions;

    /**
     * EndorsementIndexModel constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        $this->loadUser();

        $this->endorsementPositions = $this->getApprovedEndorsementsPositions();
    }

    private function getApprovedEndorsementsPositions()
    {
        $endorsements = $this->user->crew->endorsements;

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
                    'approved'    => ($endorsement->approved_at) ? 1 : 0,
                    'unapproved'  => ($endorsement->approved_at) ? 0 : 1,
                    'total'       => 1,
                ];
            } else {
                if ($endorsement->approved_at) {
                    $ret[$position->id]['approved']++;
                } else {
                    $ret[$position->id]['unapproved']++;
                }
                $ret[$position->id]['total']++;
            }
        }

        return collect($ret);
    }
}