<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Illuminate\Support\Facades\Storage;

class EditCrewPhoto
{
    /**
     * @param \App\Models\Crew $crew
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
     * @param \App\Models\Crew $crew
     */
    private function deleteOldPhoto(Crew $crew): void
    {
        Storage::disk('s3')->delete($crew->photo_path);
    }
}
