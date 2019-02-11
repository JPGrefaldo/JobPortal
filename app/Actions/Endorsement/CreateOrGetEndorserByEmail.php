<?php

namespace App\Actions\Endorsement;

use App\Models\EndorsementEndorser;
use App\Models\User;

class CreateOrGetEndorserByEmail
{
    /**
     * @param $email
     * @return EndorsementEndorser
     */
    public function execute($email)
    {
        $endorserUser = $this->getEndorserUserByEmail($email);

        return EndorsementEndorser::firstOrCreate([
            'email'   => (! $endorserUser) ? $email : null,
            'user_id' => ($endorserUser) ? $endorserUser->id : null,
        ]);
    }

    /**
     * @param string $email
     * @return User|null
     */
    private function getEndorserUserByEmail($email)
    {
        return User::whereEmail($email)->first();
    }
}
