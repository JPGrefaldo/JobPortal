<?php

namespace App\Actions\Messenger;

use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;

class StoreParticipants
{
    public function execute(Thread $thread, $recepients)
    {
        // Sender
        $thread->participants()->create([
            'user_id'   => 2,
            'last_read' => new Carbon(),
        ]);
        
        // Participant(s)
        $thread->addParticipant($recepients);
    }
}