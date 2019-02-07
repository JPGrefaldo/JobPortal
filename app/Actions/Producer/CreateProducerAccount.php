<?php

namespace App\Actions\Crew;

use App\Models\Role;
use App\Models\User;

class CreateProducerAccount
{
    /**
     * @param User $user
     * @return User
     */
    public function execute($user)
    {
        $user->assignRole(Role::PRODUCER);

        return $user;
    }
}
