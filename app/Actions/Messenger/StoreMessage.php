<?php

namespace App\Actions\Messenger;

use App\Models\Message;
use App\Models\Thread;
use App\Models\User;

class StoreMessage
{
    /**
     * @param $thread_id
     * @param $user_id
     * @param string $body
     * @return \App\Models\Message
     */
    public function execute(Thread $thread, User $user, $body): Message
    {
        return $user->messages()->create([
            'thread_id' => $thread->id,
            'body'      => $body,
        ]);
    }
}