<?php

namespace App\Actions\Crew;

use App\Models\User;

class StoreCrew
{
    /**
     * @param \App\Models\User $user
     * @param array $data
     * @throws \Exception
     */
    public function execute(User $user, array $data): void
    {
        app(EditCrew::class)->execute($user->crew, $data);

        app(StoreCrewPhoto::class)->execute($user->crew, $data);

        app(StoreCrewResume::class)->execute($user->crew, $data);

        app(StoreCrewReel::class)->execute($user->crew, $data);

        app(StoreCrewSocials::class)->execute($user->crew, $data);
    }
}
