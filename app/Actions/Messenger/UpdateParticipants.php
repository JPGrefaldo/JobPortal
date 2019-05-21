<?php

namespace App\Actions\Messenger;

use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UpdateParticipants
{
    public function execute(Thread $thread, User $user, $participants)
    {
        $thread->activateAllParticipants();

        // Sender
        $participant = $thread->participants()->firstOrCreate([
            'user_id' => $user->id
        ]);
        $participant->last_read = new Carbon;
        $participant->save();
        
        // Participant
        $thread->addParticipant($participants);

        return $thread;
    }
}
