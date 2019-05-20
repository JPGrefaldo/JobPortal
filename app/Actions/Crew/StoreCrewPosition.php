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
     * @throws \Exception
     */
    public function execute(Crew $crew, Position $position, array $data): void
    {
        $crew->positions()->syncWithoutDetaching([
            $position->id => [
                'details'           => $data['bio'],
                'union_description' => $data['union_description'],
            ],
        ]);

        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        if ($crewPosition->trashed()) {
            $crewPosition->restore();
        }

        if ($crewPosition != null) {
            $data['crew_position_id'] = $crewPosition->id;
        } else {
            $data['crew_position_id'] = null;
        }

        $crew->gears()->updateOrCreate(
            ['crew_position_id' => $data['crew_position_id'],],
            ['description' => $data['gear'],]
        );

        app(StoreCrewGear::class)->execute($crew, $data);
        app(StoreCrewResume::class)->execute($crew, $data);
        app(StoreCrewReel::class)->execute($crew, $data);
    }
}
