<?php

namespace App\Actions\Crew;


use App\Actions\Auth\AddRoleToUserByRoleName;
use App\Models\Role;
use App\Models\User;

class CreateCrewAccount
{
    /**
     * @param User $user
     * @return User
     */
    public function execute($user)
    {
        app(AddRoleToUserByRoleName::class)->execute($user, Role::CREW);
        app(StubCrew::class)->execute($user);

        return $user;
    }
}