<?php

namespace App\Actions\Producer;

use App\Actions\Messenger\StoreMessage;
use App\Actions\Messenger\StoreThread;
use App\Actions\Messenger\StoreParticipants;
use App\Models\Project;
use App\Models\User;

class StoreMessageCrew
{
    /**
     * @param $data
     * @param \App\Models\Project $project
     * @param \App\Models\User $user
     */
    public function execute(Project $project, User $user, $data): void
    {
        $message    = $data->message;
        $recipients = User::whereIn('id', $data->recipients)->get();

        foreach ($recipients as $recipient) {
            $thread = app(StoreThread::class)->execute($project, $data->subject);
            
            app(StoreParticipants::class)->execute($thread, $user, $recipient);
            app(StoreMessage::class)->execute($thread, $user, $message);
        }
    }
}
