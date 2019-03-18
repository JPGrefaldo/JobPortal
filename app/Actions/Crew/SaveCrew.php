<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class SaveCrew
{
    public function execute(User $user, $data)
    {
        $photoPath = $user->hash_id . '/photos/'. $data['photo']->hashName();

        $user->crew()->save(new Crew([
            'bio' => $data['bio'],
            'photo_path' => $photoPath,
        ]));

        Storage::disk('s3')->put(
            $photoPath,
            file_get_contents($data['photo']),
            'public'
        );
    }
}
