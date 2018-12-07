<?php

namespace App\Actions\Admin;

use App\Models\User;
use App\Models\UserBanned;

class BanUser
{
    /**
     * @param string $reason
     * @param User $user
     * @return User
     */
    public function execute(string $reason, User $user)
    {
        UserBanned::create([
            'user_id' => $user->id,
            'reason'  => $reason
        ]);
        $user->deactivate();

        return $user;
    }
}
