<?php

namespace App\Actions\User;


use App\Actions\Crew\CloseCrewAccount;
use App\Actions\Producer\CloseProducerAccount;
use App\Models\Role;
use App\Models\User;

class CloseUserAccount
{
    /**
     * @param User $user
     */
    public function execute($user)
    {
        if ($user->hasRole(Role::PRODUCER)) {
            app(CloseProducerAccount::class)->execute($user);
        }

        if ($user->hasRole(Role::CREW)) {
            app(CloseCrewAccount::class)->execute($user);
        }

        $user->update([
            'status' => 0,
        ]);
    }

}