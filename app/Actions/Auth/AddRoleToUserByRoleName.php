<?php

namespace App\Actions\Auth;


use App\Models\Role;
use App\Models\User;

class AddRoleToUserByRoleName
{
    /**
     * @param User $user
     * @param $roleName
     */
    public function execute($user, $roleName)
    {
        $role = Role::whereName($roleName)->first();
        $user->roles()->save($role);
    }
}