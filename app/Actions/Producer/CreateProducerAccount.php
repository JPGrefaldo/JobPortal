<?php

namespace App\Actions\Crew;


use App\Actions\Auth\AddRoleToUserByRoleName;
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
        app(AddRoleToUserByRoleName::class)->execute($user, Role::PRODUCER);

        return $user;
    }
}