<?php

namespace App\Actions\Crew;

use App\Models\Crew;
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

        $crew->gears()->create([
            'crew_id'          => $crew->id,
            'description'      => $data['gear'],
            'crew_position_id' => $position->id,
        ]);

        $crew->reels()->create([
            'crew_id'          => $crew->id,
            'url'              => $data['reel_link'],
            'crew_position_id' => $position->id,
        ]);
    }
}
