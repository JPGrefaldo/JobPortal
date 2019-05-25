<?php

namespace App\Actions\Messenger;

use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;

class StoreParticipants
{
    public function execute(Thread $thread, User $user, $recipient)
    {
        // Sender
        $thread->participants()->create([
            'user_id'   => $user->id,
            'last_read' => new Carbon(),
        ]);

        // Participant
        $thread->addParticipant($recipient);
    }
}
