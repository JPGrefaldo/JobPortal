<?php

namespace App\Actions\Messenger;

use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;

class UpdateParticipants
{
    public function execute(Thread $thread, User $user, $recipient)
    {
        $thread->activateAllParticipants();

        // Sender
        $participant = $thread->participants()->firstOrCreate([
            'user_id' => $user->hash_id,
        ]);
        $participant->last_read = new Carbon;
        $participant->save();
        
        // Participant
        $thread->addParticipant($recipient);

        return $thread;
    }
}
