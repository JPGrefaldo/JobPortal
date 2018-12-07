<?php
namespace App\Actions\Endorsement;

use App\Models\EndorsementEndorser;
use App\Models\User;

class ConvertEndorserFromEmailToUser
{
    /**
     * @param User $user
     */
    public function execute($user)
    {
        if (! $endorser = EndorsementEndorser::whereEmail($user->email)->first()) {
            return;
        }

        $endorser->update([
            'email' => '',
            'user_id' => $user->id
        ]);
    }
}