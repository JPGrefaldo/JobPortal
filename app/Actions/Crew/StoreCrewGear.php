<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Illuminate\Support\Facades\Storage;
use App\Models\CrewPosition;

class StoreCrewGear
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     */
    public function execute(Crew $crew, array $data): void
    {
        if (! isset($data['gear_photos']) || empty($data['gear_photos'])) {
            return;
        }

        if ($crewGear = $crew->gears()->where('crew_position_id', $data['crew_position_id'])->first()) {
            Storage::disk('s3')->delete($crewGear->path);
        }

        $path = $data['gear_photos']->store(
            $crew->user->hash_id . '/gears',
            's3',
            'public'
        );

        $crewGear->update([
            'path' => $path,
        ]);
    }
}