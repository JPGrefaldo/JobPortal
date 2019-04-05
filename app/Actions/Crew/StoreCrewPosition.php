<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;

class StoreCrewPosition
{
    /**
     * @param \App\Models\Crew $crew
     * @param \App\Models\Position $position
     * @param array $data
     */
    public function execute(Crew $crew, Position $position, array $data): void
    {
        $crew->positions()->attach($position, [
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        $crew->gears()->create([
            'description'      => $data['gear'],
            'crew_position_id' => $crewPosition->id,
        ]);

        $crew->reels()->create([
            'crew_id'          => $crew->id,
            'path'             => $data['reel_link'],
            'crew_position_id' => $crewPosition->id,
        ]);
    }
}
