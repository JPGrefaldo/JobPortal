<?php

namespace App\Actions\Producer;

use App\Actions\Messenger\StoreMessage;
use App\Actions\Messenger\StoreParticipants;
use App\Models\Project;
use App\Models\Thread;
use App\Models\User;

class UpdateMessageCrew
{
    /**
     * @param $data
     * @param Project $project
     * @param User $user
     */
    public function execute(Project $project, User $user, $data): void
    {
        $message = $data->message;
        $recipients = User::whereIn('id', $data->recipients)->get();

        foreach ($recipients as $recipient) {
            $thread = Thread::getByProjectAndParticipant($project, $recipient);
            app(StoreParticipants::class)->execute($thread, $user, $recipient);
            app(StoreMessage::class)->execute($thread, $user, $message);
        }
    }
}
