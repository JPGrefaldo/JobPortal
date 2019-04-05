<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Illuminate\Support\Facades\Storage;

class SaveCrewResume
{
    public function execute(Crew $crew, array $data)
    {
        $resumePath = $crew->user->hash_id . '/resumes/' . $data['resume']->hashName();

        $crew->resumes()->create([
            'path'    => $resumePath,
            'general' => true,
        ]);

        Storage::disk('s3')->put(
            $resumePath,
            file_get_contents($data['resume']),
            'public'
        );
    }
}
