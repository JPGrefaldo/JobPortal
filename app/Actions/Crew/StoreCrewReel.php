<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreCrewReel
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     * @param bool $general
     * @throws \Exception
     */
    public function execute(Crew $crew, array $data): void
    {
        if (! isset($data['reel']) || empty($data['reel'])) {
            return;
        }

        $reel = $crew->reels()->where('general', true)->first();

        if ($reel && Str::contains($reel->path, $crew->user->hash_id)) {
            Storage::disk('s3')->delete($reel->path);
        }

        if ($this->isUploadedFile($data)) {
            $reelPath = $data['reel']->store(
                $crew->user->hash_id . '/reels',
                's3',
                'public'
            );
        } else {
            $reelPath = app(CleanVideoLink::class)->execute($data['reel']);
        }

        $crew->reels()->updateOrCreate([
            'general' => true,
        ], [
            'path'    => $reelPath,
            'general' => true,
        ]);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function isUploadedFile(array $data): bool
    {
        return $data['reel'] instanceof UploadedFile;
    }
}
