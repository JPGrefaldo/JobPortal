<?php

namespace App\Actions\Admin;

use App\Models\Project;
use App\Models\ProjectThread;
use App\Models\Thread;
use App\Models\User;
use App\Actions\Messenger\StoreThread;
use App\Actions\Messenger\StoreParticipants;

class MessageCrew
{
    /**
     * @param $data
     * @param \App\Models\Project $project
     * @param \App\Models\User $user
     */
    public function execute(Project $project, User $user, Request $request): void
    {
        $message    = $request->message;
        $recipients = User::whereIn('hash_id', $request->recipients)->get();

        foreach ($recipients as $recipient) {
            $thread = Thread::getByProjectAndParticipant($project, $recipient);

            if (empty($thread)) {
                $thread = app(StoreThread::class)->execute($user, $request->subject);
            }
            
            app(StoreParticipants::class)->execute($thread, $user, $recipient);
            app(StoreMessage::class)->execute($thread, $user, $message);
        }
    }
}
