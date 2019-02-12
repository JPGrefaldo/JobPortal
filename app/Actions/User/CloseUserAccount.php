<?php

namespace App\Actions\User;

use App\Actions\Crew\CloseCrewAccount;
use App\Actions\Producer\CloseProducerAccount;
use App\Models\User;

class CloseUserAccount
{
    /**
     * @param User $user
     */
    public function execute(User $user): void
    {
        app(CloseProducerAccount::class)->execute($user);

        app(CloseCrewAccount::class)->execute($user);

        $user->update([
            'status' => 0,
        ]);
    }
}
