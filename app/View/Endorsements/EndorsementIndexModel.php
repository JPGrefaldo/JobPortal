<?php

namespace App\View\Endorsements;

use App\Models\EndorsementEndorser;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;

class EndorsementIndexModel extends ViewModel
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var Collection
     */
    public $endorsements;

    public $pending_endorsements;

    /**
     * @var HasMany
     */
    public $crewPositions;

    /**
     * @var integer
     */
    public $total_endorsements;

    /**
     * @var Collection
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

    /**
     * @return Collection
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
}
