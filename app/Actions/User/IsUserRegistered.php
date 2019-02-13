<?php

namespace App\Actions\User;

use App\Models\User;
use App\Utils\FormatUtils;

class IsUserRegistered
{
    /**
     * @param string $email
     * @return \App\Models\User|false
     */
    public function execute($email)
    {
        $email = FormatUtils::email($email);

        if ($user = User::where('email', $email)->first()) {
            return $user;
        }

        return false;
    }
}
