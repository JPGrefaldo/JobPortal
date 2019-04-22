<?php

namespace App\Actions\Crew;

use App\Models\Role;
use App\Models\User;

class CloseCrewAccount
{
    /**
     * @param User $user
     */
    public function execute(User $user): void
    {
        if (! $user->hasRole(Role::CREW)) {
            return;
        }
    }
}
