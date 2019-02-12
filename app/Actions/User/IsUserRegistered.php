<?php

namespace App\Actions\User;

use App\Models\User;
use App\Utils\FormatUtils;

class IsUserRegistered
{
    /**
     * @param string $email
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
