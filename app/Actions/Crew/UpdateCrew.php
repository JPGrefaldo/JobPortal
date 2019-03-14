<?php

namespace App\Actions\Crew;

use App\Models\Crew;

class UpdateCrew
{
    public function execute(Crew $crew, array $data)
    {
        app(EditCrew::class)->execute($crew, $data);

        app(EditCrewResume::class)->execute($crew, $data);

        app(EditCrewReel::class)->execute($crew, $data);

        app(EditCrewSocials::class)->execute($crew, $data);
    }
}
