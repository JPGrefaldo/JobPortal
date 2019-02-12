<?php

namespace App\Actions\User;

use App\Models\User;

class ChangeUserPassword
{
    /**
     * @param User $user
     * @param string $password
     */
    public function execute(User $user, $password): void
    {
        $user->update([
            'password' => \Hash::make($password),
        ]);
    }
}