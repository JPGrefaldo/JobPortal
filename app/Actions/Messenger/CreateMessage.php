<?php

namespace App\Actions\Messenger;

use Cmgmyr\Messenger\Models\Message;

class CreateMessage
{
    /**
     * @param string $managerId
     * @param string $subordinateId
     * @return \Cmgmyr\Messenger\Models\Message
     */
    public function execute($thread, $user, $body)
    {
        return Message::create([
            'thread_id' => $thread,
            'user_id'   => $user,
            'body'      => $body,
        ]);
    }
}
