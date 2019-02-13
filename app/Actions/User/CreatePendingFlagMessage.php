<?php

namespace App\Actions\User;

use App\Mail\PendingMessageFlagged;
use App\Models\PendingFlagMessage;
use App\Models\User;
use Cmgmyr\Messenger\Models\Message;
use Illuminate\Support\Facades\Mail;

class CreatePendingFlagMessage
{
    /**
     * @param array $data
     */
    public function execute($data): void
    {
        $message = Message::find($data['message_id']);

        PendingFlagMessage::create([
            'message_id' => $message->id,
            'reason' => $data['reason'],
        ]);

        // TODO: defer to on PendingFlagMessage create
        Mail::to('admin@admin.com')->send(new PendingMessageFlagged($message));
    }
}
