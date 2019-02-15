<?php

namespace App\Actions\Crew;

use App\Models\CrewGear;
use App\Models\CrewPosition;
use App\Models\CrewReel;

class StoreCrewPosition
{
    public function execute($crew, $position, $data)
    {
        $crew->positions()->attach($position, [
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        $crewGear = new CrewGear([
            'description'      => $data['gear'],
            'crew_position_id' => $position->id
        ]);
        $crew->gears()->save($crewGear);

        $crewReel = new CrewReel([
            'crew_id'          => $crew->id,
            'url'              => $data['reel_link'],
            'crew_position_id' => $crewPosition->id,
        ]);

        $crew->reels()->save($crewReel);
    }
}
