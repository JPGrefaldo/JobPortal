<?php

namespace App\Actions\Messenger;

use Cmgmyr\Messenger\Models\Message;

class StoreMessage
{
    /**
     * @param $thread_id
     * @param $user_id
     * @param string $body
     * @return \Cmgmyr\Messenger\Models\Message
     */
    public function execute($thread_id, $user_id, $body): Message
    {
        return Message::create([
            'thread_id' => $thread_id,
            'user_id'   => $user_id,
            'body'      => $body,
        ]);
    }
}
