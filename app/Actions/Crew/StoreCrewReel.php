<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreCrewReel
{
    /**
     * @param Crew $crew
     * @param array $data
     * @throws Exception
     */
    public function execute(Crew $crew, array $data): void
    {
        if (! (isset($data['reel_link']) || isset($data['reel_file']))
            || (empty($data['reel_link']) && empty($data['reel_file']))) {
            return;
        }

        $reel = $crew->reels()->where('general', true)->first();

        if ($reel && Str::contains($reel->path, $crew->user->hash_id)) {
            Storage::disk('s3')->delete($reel->path);
        }

        if ($this->isUploadedFile($data)) {
            $values['path'] = $data['reel_file']->store(
                $crew->user->hash_id . '/reels',
                's3',
                'public'
            );
        } else {
            $values['path'] = app(CleanVideoLink::class)->execute($data['reel_link']);
        }

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

        $crew->reels()->updateOrCreate($attributes, $values);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function isUploadedFile(array $data): bool
    {
        return ($data['reel_file'] ?? false) instanceof UploadedFile;
    }
}
