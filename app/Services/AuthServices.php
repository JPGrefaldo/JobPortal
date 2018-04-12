<?php


namespace App\Services;


use App\Role;
use App\Site;
use App\User;
use Illuminate\Support\Str;

class AuthServices
{
    /**
     * @param string $roleName
     * @param User $user
     * @param Site $site
     *
     * @throws \Exception
     */
    public function createByRoleName($roleName, User $user, Site $site)
    {
        $role = Role::whereName($roleName)->first();

        if (! $role) {
            throw new \Exception('Role not found');
        }

        $user->roles()->save($role);
        $user->sites()->save($site);
        $user->emailVerificationCode()->create([
            'code' => Str::uuid()
        ]);
    }
}