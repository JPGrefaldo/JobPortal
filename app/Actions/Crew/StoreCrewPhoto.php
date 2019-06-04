<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Illuminate\Support\Facades\Storage;

class StoreCrewPhoto
{
    /**
     * @param Crew $crew
     * @param array $data
     */
    public function execute(Crew $crew, array $data): void
    {
        if (! isset($data['photo']) || empty($data['photo'])) {
            return;
        }

        $this->deleteOldPhoto($crew);

        $crew->update([
            'photo_path' => $data['photo']->store(
                $crew->user->hash_id . '/photos',
                's3',
                'public'
            ),
        ]);
    }

    /**
     * @param Crew $crew
     */
    private function deleteOldPhoto(Crew $crew): void
    {
        if ($crew->photo_path) {
            Storage::disk('s3')->delete($crew->photo_path);
        }
    }
}
