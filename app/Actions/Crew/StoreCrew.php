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

        $crew = $user->crew;

        app(EditCrewPhoto::class)->execute($crew, $data);

        if ($data['resume']) {
            app(SaveCrewResume::class)->execute($crew, $data);
        }

        if ($data['reel']) {
            app(SaveCrewReel::class)->execute($crew, $data);
        }

        app(SaveCrewSocials::class)->execute($crew, $data);
    }
}
