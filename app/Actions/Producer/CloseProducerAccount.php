<?php

namespace App\Actions\Producer;

use App\Models\Role;
use App\Models\User;

class CloseProducerAccount
{
    /**
     * @param User $user
     */
    public function execute(User $user): void
    {
        if (! $user->hasRole(Role::PRODUCER)) {
            return;
        }
    }
}
