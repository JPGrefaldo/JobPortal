<?php

namespace App\Actions\Crew;

use App\Models\User;

class StubCrew
{
    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function execute(User $user)
    {
        return $user->crew()->create([
            'user_id'   => $user->id,
            'photo_path'     => 'photos/avatar.png',
        ]);
    }
}
