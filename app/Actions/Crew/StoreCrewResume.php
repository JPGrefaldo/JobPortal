<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Illuminate\Support\Facades\Storage;

class StoreCrewResume
{
    /**
     * @param Crew $crew
     * @param array $data
     */
    public function execute(Crew $crew, array $data): void
    {
        if (! isset($data['resume']) || $data['resume'] == "null") {
            return;
        }

        if ($crewResume = $crew->resumes()->where('general', true)->first()) {
            Storage::disk('s3')->delete($crewResume->path);
        }

        $values['path'] = $data['resume']->store(
            $crew->user->hash_id . '/resumes',
            's3',
            'public'
        );

        $attributes = [
            'general' => true,
        ];

        $values['general'] = true;

        if (isset($data['crew_position_id'])) {
            $attributes = [
                'crew_position_id' => $data['crew_position_id'],
            ];

            $values['crew_position_id'] = $data['crew_position_id'];
            $values['general'] = false;
        }

        $crew->resumes()->updateOrCreate($attributes, $values);
    }
}
