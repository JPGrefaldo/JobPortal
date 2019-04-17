<?php

namespace App\Actions\Crew;

use Illuminate\Support\Str;
use App\Models\Crew;
use Illuminate\Support\Facades\Storage;

class EditCrewReel
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     * @throws \Exception
     */
    public function execute(Crew $crew, array $data): void
    {
        if (! $crew->hasGeneralReel()) {
            app(SaveCrewReel::class)->execute($crew, $data);
            return;
        }

        $reel = $crew->reels()->where('general', true)->first();

        if (Str::contains($reel->path, $crew->user->hash_id)) {
            Storage::disk('s3')->delete($reel->path);
        }

        if (gettype($data['reel']) === 'string') {
            $reelPath = app(CleanVideoLink::class)->execute($data['reel']);
        } else {
            $reelPath = $data['reel']->store(
                $crew->user->hash_id . '/reels',
                's3'
            );
        }

        $reel->update([
            'path' => $reelPath,
        ]);
    }
}
