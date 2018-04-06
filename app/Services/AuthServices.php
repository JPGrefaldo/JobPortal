<?php


namespace App\Services;


use App\Role;
use App\User;

class AuthServices
{
    public function createCrew(User $user)
    {
        $role = Role::whereName(Role::CREW)->first();

        $user->roles()->save($role);
    }
}