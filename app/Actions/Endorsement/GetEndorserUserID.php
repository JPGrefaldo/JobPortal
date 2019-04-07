<?php

namespace App\Actions\Endorsement;

use App\Models\User;

class GetEndorserUserID
{
    /**
     * @param $email
     * @return \App\Models\User
     */
    public function execute($email): User
    {
        return User::whereEmail($email)->firstOrFail();
    }
}
