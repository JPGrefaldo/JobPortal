<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Illuminate\Support\Facades\Storage;

class EditCrewReel
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     */
    public function execute(Crew $crew, array $data): void
    {
        $reel = $crew->reels()->where('general', true)->first();

        if (! $reel) {
            app(SaveCrewReel::class)->execute($crew, $data);
            return;
        }

        if (str_contains($reel->path, $crew->user->hash_id)) {
            Storage::disk('s3')->delete($reel->path);
        }

        if (gettype($data['reel']) === 'string') {
            $reelPath = app(CleanVideoLink::class)->execute($data['reel']);
        } else {
            $reelPath = $crew->user->hash_id . '/reels/'. $data['reel']->hashName();

            Storage::disk('s3')->put(
                $reelPath,
                file_get_contents($data['reel']),
                'public'
            );
        }

        $reel->update([
            'path' => $reelPath,
        ]);
    }
}
