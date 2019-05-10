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
            if ($crew->gears()->where('crew_position_id', $crewPosition->id)->first()) {
                $crew->gears()->where('crew_position_id', $crewPosition->id)->update([
                    'description'      => $data['gear'],
                ]);
            } else {
                $crew->gears()->create([
                    'description'      => $data['gear'],
                    'crew_position_id' => $crewPosition->id,
                ]);
            }
        }

        if ($data['reel_link'] != null) {
            if ($crew->reels()->where('crew_position_id', $crewPosition->id)->first()) {
                $crew->reels()->where('crew_position_id', $crewPosition->id)->update([
                    'crew_id'          => $crew->id,
                    'path'             => $data['reel_link'],
                ]);
            } else {
                $crew->reels()->create([
                    'crew_id'          => $crew->id,
                    'path'             => $data['reel_link'],
                    'crew_position_id' => $crewPosition->id,
                ]);
            }
        }
    }
}
