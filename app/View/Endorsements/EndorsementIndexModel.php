<?php

namespace App\View\Endorsements;

use App\Models\User;
use Spatie\ViewModels\ViewModel;
use App\Models\EndorsementEndorser;

class EndorsementIndexModel extends ViewModel
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $endorsements;

    public $pending_endorsements;

    /**
     * @var \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public $crewPositions;

    /**
     * @var integer
     */
    public $total_endorsements;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $positions;

    /**
     * EndorsementIndexModel constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->loadUser();

        $this->crewPositions = $this->user->crew->crewPositions;

        $this->getPositions();

        $this->endorsements = $this->buildEndorsementCollection();

        $this->pending_endorsements = EndorsementEndorser::where('user_id', auth()->user()->id)->with([
            'request',
            'owner',
            'user.crew.crewPositions',
        ])->get();

        // dd(
        //     $this->pending_endorsements->with([
        //         'request',
        //         'user',
        //         'user.crew',
        //         'user.crew.crewPositions',
        //     ])->first()->request->endorsement->crewPosition->position->name
        // );
    }

    private function loadUser()
    {
        $this->user->load([
            'crew',
            'crew.crewPositions',
            'crew.crewPositions.position',
            'crew.crewPositions.endorsements',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function buildEndorsementCollection()
    {
        $ret = [];
        $this->total_endorsements = 0;

        foreach ($this->crewPositions as $position) {
            foreach ($position->endorsements as $endorsement) {
                $this->total_endorsements++;
                if (! isset($ret[$position->position_id])) {
                    $ret[$position->position_id] = [
                        'crew_position' => $position,
                        'position'      => $position->position,
                        'endorsement'   => $endorsement,
                        'approved'      => ($endorsement->approved_at) ? 1 : 0,
                        'unapproved'    => ($endorsement->approved_at) ? 0 : 1,
                        'total'         => 1,
                    ];
                } else {
                    if ($endorsement->approved_at) {
                        $ret[$position->position_id]['approved']++;
                    } else {
                        $ret[$position->position_id]['unapproved']++;
                    }
                    $ret[$position->position_id]['total']++;
                }
            }
        }

        return collect($ret);
    }

    public function getPositions()
    {
        $this->positions = collect([]);

        if (! $this->crewPositions->count()) {
            return;
        }

        foreach ($this->crewPositions as $crewPosition) {
            $this->positions->push($crewPosition->position);
        }

        $this->positions = $this->positions->sortBy('name');
    }

    public function getPendingEndorsementRequest()
    {

    }
}
