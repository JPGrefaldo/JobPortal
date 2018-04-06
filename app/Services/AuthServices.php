<?php


namespace App\Services;


use App\Role;
use App\Site;
use App\User;

class AuthServices
{
    /**
     * @param User $user
     * @param Site $site
     */
    public function createCrew(User $user, Site $site)
    {
        $role = Role::whereName(Role::CREW)->first();

        $user->roles()->save($role);
        $user->sites()->save($site);
    }
}