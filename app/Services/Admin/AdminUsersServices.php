<?php


namespace App\Services\Admin;


use App\Models\User;
use App\Models\UserBanned;

class AdminUsersServices
{
    /**
     * @param string           $reason
     * @param \App\Models\User $user
     *
     * @return \App\Models\User
     */
    public function ban(string $reason, User $user)
    {
        UserBanned::create([
            'user_id' => $user->id,
            'reason'  => $reason
        ]);
        $user->deactivate();

        return $user;
    }
}