<?php

namespace App\Actions\Auth;


use App\Models\Site;
use App\Models\User;
use App\Models\UserSites;

class AddUserToSite
{
    /**
     * @param User $user
     * @param Site $site
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function execute(User $user, Site $site)
    {
        return UserSites::firstOrCreate([
            'user_id' => $user->id,
            'site_id' => $site->id,
        ]);
    }
}