<?php

namespace App\View\Endorsements;

use App\Actions\Crew\GetCrewPositionByPosition;
use App\Actions\Endorsement\GetEndorsements;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
use App\Models\Position;
use App\Models\User;
use App\View\InitialJS;
use Spatie\ViewModels\ViewModel;

class EndorsementPositionShowModel extends ViewModel
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var Position
     */
    public $position;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $approvedEndorsements;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $pendingEndorsements;
    /**
     * @var \Illuminate\Support\Collection
     */
    public $initJS;

    /**
     * EndorsementIndexModel constructor.
     * @param User $user
     * @param $position
     */
    public function __construct(User $user, $position)
    {
        $this->user = $user;
        $this->loadUser();

        $this->position = $position;

        $this->getEndorsements();

        app(InitialJS::class)->pushJson('approved_endorsements', json_encode($this->approvedEndorsements->toArray()));
        app(InitialJS::class)->pushJson('pending_endorsements', json_encode($this->pendingEndorsements->toArray()));
    }

    private function loadUser()
    {
        $this->user->load([
            'crew',
        ]);
    }

    private function getEndorsements()
    {
        $this->approvedEndorsements = app(GetEndorsements::class)->execute($this->user, $this->position, true);
        $this->pendingEndorsements = app(GetEndorsements::class)->execute($this->user, $this->position);
    }
}