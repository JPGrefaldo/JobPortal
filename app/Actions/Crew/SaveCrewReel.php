<?php

namespace App\Actions\Crew;

use App\Models\Crew;

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

        $crew->reels()->create([
            'path'    => $reelPath,
            'general' => true,
        ]);
    }
}
