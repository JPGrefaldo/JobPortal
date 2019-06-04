<?php

namespace App\Actions\Endorsement;

use App\Models\EndorsementEndorser;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateOrGetEndorserByEmail
{
    /**
     * @param $email
     * @return EndorsementEndorser
     */
    public function execute($email): EndorsementEndorser
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
        try {
            return app(GetEndorserUserID::class)->execute($email);
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }
}
