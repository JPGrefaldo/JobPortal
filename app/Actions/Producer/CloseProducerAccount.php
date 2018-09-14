<?php

namespace App\Actions\Producer;


use App\Models\Role;
use App\Models\User;

class CloseProducerAccount
{
    /**
     * @param User $user
     */
    public function execute($user)
    {
        if (! $user->hasRole(Role::PRODUCER)) {
            return;
        }
    }
}