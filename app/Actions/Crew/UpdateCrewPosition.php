<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;

class UpdateCrewPosition
{
    /**
     * @param Crew $crew
     * @param Position $position
     * @param array $data
     */
    public function execute(Crew $crew, Position $position, array $data): void
    {
        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        $crewPosition->update([
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        $crew->gears()->updateOrCreate(
            ['crew_position_id' => $crewPosition->id],
            ['description' => $data['gear'],]
        );

        $crew->reels()->updateOrCreate(
            ['crew_position_id', $crewPosition->id],
            [
                'crew_id' => $crew->id,
                'path'    => $data['reel_link'],
            ]
        );
    }
}
