<?php

namespace App\Actions\Crew;

use App\Models\Crew;

class UpdateCrew
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     * @throws \Exception
     */
    public function execute(Crew $crew, array $data): void
    {
        app(EditCrew::class)->execute($crew, $data);

        app(StoreCrewPhoto::class)->execute($crew, $data);

        app(StoreCrewResume::class)->execute($crew, $data);

        app(StoreCrewReel::class)->execute($crew, $data);

        app(StoreCrewSocials::class)->execute($crew, $data);
    }
}
