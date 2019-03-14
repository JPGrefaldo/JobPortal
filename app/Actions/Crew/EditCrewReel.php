<?php

namespace App\Actions\Crew;

use App\Models\Crew;

class EditCrewReel
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     */
    public function execute(Crew $crew, array $data): void
    {
        $reelPath = app(CleanVideoLink::class)->execute($data['reel']);

        $crew->reels()
            ->where('general', true)
            ->update([
                'path' => $reelPath,
            ]);
    }
}
