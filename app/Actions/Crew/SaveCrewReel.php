<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewReel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SaveCrewReel
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     * @throws \Exception
     */
    public function execute(Crew $crew, array $data): void
    {
        if ($data['reel'] instanceof UploadedFile) {
            $reelPath = $crew->user->hash_id . '/reels/'. $data['reel']->hashName();
            Storage::disk('s3')->put(
                $reelPath,
                file_get_contents($data['reel']),
                'public'
            );
        } else {
            $reelPath = app(CleanVideoLink::class)->execute($data['reel']);
        }

        $crew->reels()->save(new CrewReel([
            'path'    => $reelPath,
            'general' => true,
        ]));
    }
}
