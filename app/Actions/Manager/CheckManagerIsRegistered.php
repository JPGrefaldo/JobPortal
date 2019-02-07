<?php

namespace App\Actions\Manager;

use App\Models\User;
use App\Utils\FormatUtils;

class CheckManagerIsRegistered
{
    /**
     * @param string $email
     */
    public function execute($email)
    {
        $email = FormatUtils::email($email);

        if ($user = User::where('email', $email)->first()){
            return $user;
        }

        return false;
    }
}