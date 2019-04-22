<?php

namespace App\Actions\Crew;

use App\Models\Role;
use App\Models\User;

class CreateCrewAccount
{
    /**
     * @param User $user
     * @return User
     */
    public function execute(User $user): User
    {
        $user->assignRole(Role::CREW);

        app(StubCrew::class)->execute($user);

        return $user;
    }
}
