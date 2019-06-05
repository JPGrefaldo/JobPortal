<?php

namespace App\Actions\Endorsement;

use App\Models\User;

class GetEndorserUserID
{
    /**
     * @param $email
     * @return User
     */
    public function execute($email): User
    {
        return User::whereEmail($email)->firstOrFail();
    }
}
