<?php

namespace App\Actions\Messenger;

use App\Http\Resources\ParticipantResource;

class SearchParticipants
{
    public function execute($thread, $keyword)
    {
        $user = auth()->user()->id;

        $users = $thread->users()
            ->where('user_id', '!=', $user)
            ->where('first_name', 'like', '%'.ucfirst(strtolower($keyword)).'%')
            ->orWhere('last_name', 'like', '%'.ucfirst(strtolower($keyword)).'%')
            ->orWhere('nickname', 'like', '%'.ucfirst(strtolower($keyword)).'%')
            ->get();

        return ParticipantResource::collection($users);
    }
}
