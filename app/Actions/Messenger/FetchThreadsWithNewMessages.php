<?php

namespace App\Actions\Messenger;

use App\Models\User;

class FetchThreadsWithNewMessages
{
    /**
     * @param User $user
     * @return Message
     */
    public function execute(User $user)
    {
        return $user->threads()
                    ->with('messages')
                    ->latest('updated_at')
                    ->get();
    }
}
