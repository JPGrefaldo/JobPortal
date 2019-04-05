<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Illuminate\Support\Facades\Storage;

class EditCrewResume
{
    public function execute(Crew $crew, array $data)
    {
        $crewResume = $crew->resumes()->where('general', true)->first();

        Storage::disk('s3')->delete($crewResume->path);

        if ($data['resume']) {
            $resumePath = $crew->user->hash_id . '/resumes/' . $data['resume']->hashName();

            Storage::disk('s3')->put(
                $resumePath,
                file_get_contents($data['resume']),
                'public'
            );
        } else {
            $resumePath = null;
        }

        $crewResume->update([
            'path'    => $resumePath,
            'general' => true,
        ]);
    }
}
