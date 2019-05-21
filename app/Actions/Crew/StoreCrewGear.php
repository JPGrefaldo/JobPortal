<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Illuminate\Support\Facades\Storage;

class StoreCrewGear
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     */
    public function execute(Crew $crew, array $data): void
    {
        if ($crewGear = $crew->gears()->where('crew_position_id', $data['crew_position_id'])->first()) {
            Storage::disk('s3')->delete($crewGear->path);
        }

        $path = $data['gear_photos']->store(
            $crew->user->hash_id . '/gears',
            's3',
            'public'
        );

        $crew->gears()->updateOrCreate(
            ['crew_position_id' => $data['crew_position_id'],],
            [
                'description' => $data['gear'],
                'path'        => $path,
            ]
        );
    }
}
