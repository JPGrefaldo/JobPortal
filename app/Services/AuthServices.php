<?php


namespace App\Services;


use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\Crew;
use App\Utils\StrUtils;
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

        $userRole = UserRoles::where('user_id', $user->id)->first();

        if ($userRole->role_id == 3) {
            
            $crew = new Crew;
            $crew->user_id = $user->id;
            $crew->photo = "photos/avatar.png";
            $crew->save();
        }

        $user->emailVerificationCode()->create([
            'code' => StrUtils::createRandomString(),
        ]);
    }
}