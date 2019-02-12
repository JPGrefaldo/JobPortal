<?php

namespace App\Actions\Endorsement;

use App\Models\User;

class GetEndorserUserID
{
    /**
     * @param $email
     * @return \App\Models\User|null
     */
    public function execute($email)
    {
        return User::whereEmail($email)->first();
    }
}
