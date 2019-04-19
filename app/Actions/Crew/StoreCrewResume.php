<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Illuminate\Support\Facades\Storage;

class StoreCrewResume
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     */
    public function execute(Crew $crew, array $data): void
    {
        if (! isset($data['resume']) || empty($data['resume'])) {
            return;
        }

        if ($crewResume = $crew->resumes()->where('general', true)->first()) {
            Storage::disk('s3')->delete($crewResume->path);
        }

        $resumePath = $data['resume']->store(
            $crew->user->hash_id . '/resumes',
            's3',
            'public'
        );

        $crew->resumes()->updateOrCreate([
            'general' => true,
        ], [
            'path'    => $resumePath,
            'general' => true,
        ]);
    }
}
