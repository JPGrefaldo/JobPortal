<?php

namespace App\Actions\Messenger;

use App\Http\Resources\ParticipantResource;
use App\Models\Thread;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SearchParticipants
{
    /**
     * @param $thread
     * @param $keyword
     * @return AnonymousResourceCollection
     */
    public function execute(Thread $thread, $keyword): AnonymousResourceCollection
    {
        $user = auth()->user()->id;

        $users = $thread->users()
            ->where('user_id', '!=', $user)
            ->where('first_name', 'like', '%' . ucfirst(strtolower($keyword)) . '%')
            ->orWhere('last_name', 'like', '%' . ucfirst(strtolower($keyword)) . '%')
            ->orWhere('nickname', 'like', '%' . ucfirst(strtolower($keyword)) . '%')
            ->get();

        return ParticipantResource::collection($users);
    }
}
