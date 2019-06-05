<?php

namespace App\Actions\Crew;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class StubCrew
{
    /**
     * @param User $user
     * @return Model
     */
    public function execute(User $user)
    {
        return $user->crew()->create([
            'user_id'    => $user->id,
            'photo_path' => '',
        ]);
    }
}
