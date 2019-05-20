<?php

namespace App\Actions\Messenger;

use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;
use App\Models\User;

class FetchNewMessages
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
