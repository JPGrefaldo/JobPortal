<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;

class UpdateCrewPosition
{
    /**
     * @param \App\Models\Crew $crew
     * @param \App\Models\Position $position
     * @param array $data
     */
    public function execute(Crew $crew, Position $position, array $data): void
    {
        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        $crewPosition->update([
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        if ($data['gear'] != null) {
            $crew->gears()->update([
                'description'      => $data['gear'],
                'crew_position_id' => $crewPosition->id,
            ]);
        }

        $crew->reels()->update([
            'crew_id'          => $crew->id,
            'path'             => $data['reel_link'],
            'crew_position_id' => $crewPosition->id,
        ]);
    }
}
