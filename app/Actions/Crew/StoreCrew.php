<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\Role;
use App\Models\User;

class StoreCrew
{
    public function execute(User $user, array $data)
    {
        app(EditCrew::class)->execute($user->crew, $data);

        app(StoreCrewPhoto::class)->execute($user->crew, $data);

        app(StoreCrewResume::class)->execute($user->crew, $data);

        app(StoreCrewReel::class)->execute($user->crew, $data);

        app(StoreCrewSocials::class)->execute($user->crew, $data);
    }
}
