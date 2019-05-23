<?php

namespace App\Actions\Messenger;

use App\Models\Thread;
use App\Models\User;
use App\Models\Message;

class StoreMessage
{
    /**
     * @param $thread_id
     * @param $user_id
     * @param string $body
     * @return \Cmgmyr\Messenger\Models\Message
     */
    public function execute(Thread $thread, User $user, $body): Message
    {
        return $user->messages()->create([
            'thread_id' => $thread->id,
            'body'      => $body,
        ]);
    }
}
