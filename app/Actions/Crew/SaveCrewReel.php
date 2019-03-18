<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewReel;

class SaveCrewReel
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     * @throws \Exception
     */
    public function execute(Crew $crew, array $data): void
    {
        $reelPath = app(CleanVideoLink::class)->execute($data['reel']);

        $crew->reels()->save(new CrewReel([
            'path'    => $reelPath,
            'general' => true,
        ]));
    }
}
