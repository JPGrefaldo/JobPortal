<?php

namespace App\Actions\Auth;

use App\Models\Site;
use App\Models\User;
use App\Models\UserSite;

class AddUserToSite
{
    /**
     * @param User $user
     * @param Site $site
     * @return UserSite
     */
    public function execute(User $user, Site $site)
    {
        return UserSite::firstOrCreate([
            'user_id' => $user->id,
            'site_id' => $site->id,
        ]);
    }
}
