<?php

namespace App\Actions\Endorsement;

use App\Models\EndorsementEndorser;
use App\Models\User;

class ConvertEndorserFromEmailToUser
{
    /**
     * @param User $user
     */
    public function execute(User $user): void
    {
        if (! $endorser = EndorsementEndorser::whereEmail($user->email)->first()) {
            return;
        }

        $endorser->update([
            'email'   => '',
            'user_id' => $user->id,
        ]);
    }
}
