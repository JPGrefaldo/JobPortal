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
        $oldPath = $crew->photo_path;
        $s3 = Storage::disk('s3');
        $s3->delete($oldPath);

        if ($data['photo']) {
            $photoPath = $crew->user->hash_id . '/photos/' . $data['photo']->hashName();

            Storage::disk('s3')->put(
                $photoPath,
                file_get_contents($data['photo']),
                'public'
            );
        } else {
            $photoPath = null;
        }

        $crew->update([
            'photo_path' => $photoPath,
        ]);
    }
}
