<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\Role;
use App\Models\User;

class StoreCrew
{
    public function execute(User $user, array $data)
    {
        app(SaveCrew::class)->execute($user, $data);

        $user->assignRole(Role::CREW);

        $crew = $user->crew;

        if ($data['resume']) {
            app(SaveCrewResume::class)->execute($crew, $data);
        }

        if ($data['reel']) {
            app(SaveCrewReel::class)->execute($crew, $data);
        }

        app(SaveCrewSocials::class)->execute($crew, $data);
    }
}
