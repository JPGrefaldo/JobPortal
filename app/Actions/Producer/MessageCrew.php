<?php

namespace App\Actions\Admin;

use App\Models\User;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Carbon;

class MessageCrew
{
    public function execute($data, User $user)
    {
        $recipients = User::whereIn('hash_id', $data['recipients'])->get();

        foreach ($recipients as $recipient) {
            $thread = Thread::create([
                'subject' => $data['subject'],
            ]);

            Message::create([
                'thread_id' => $thread->id,
                'user_id' => $user->id,
                'body' => $data['message'],
            ]);

            Participant::create([
                'thread_id' => $thread->id,
                'user_id' => $user->id,
                'last_read' => new Carbon(),
            ]);

            $thread->addParticipant($recipient->id);

            // TODO: queue send emails
        }
    }
}
