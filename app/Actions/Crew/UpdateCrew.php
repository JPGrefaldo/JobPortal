<?php

namespace App\Actions\Crew;

use App\Models\Crew;

class UpdateCrew
{
    public function execute(Crew $crew, array $data)
    {
        app(EditCrew::class)->execute($crew, $data);

        app(StoreCrewPhoto::class)->execute($crew, $data);

        app(StoreCrewResume::class)->execute($crew, $data);

        app(StoreCrewReel::class)->execute($crew, $data);

        app(StoreCrewSocials::class)->execute($crew, $data);
    }
}
