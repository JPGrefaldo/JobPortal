<?php

namespace App\Actions\Admin;

use App\Models\Project;
use App\Models\ProjectThread;
use App\Models\Thread;
use App\Models\User;

class MessageCrew
{
    /**
     * @param $data
     * @param \App\Models\Project $project
     * @param \App\Models\User $user
     */
    public function execute($data, Project $project, User $user): void
    {
        $message    = $data['message'];
        $recipients = User::whereIn('hash_id', $data['recipients'])->get();

        foreach ($recipients as $recipient) {
            $thread = Thread::getByProjectAndParticipant($project, $recipient);

            if (empty($thread)) {
                $thread = Thread::create([
                    'subject' => $user->fullName
                ]);

                ProjectThread::create([
                    'project_id' => $project->id,
                    'thread_id'  => $thread->id
                ]);
            }

            $thread->messages()->create(
                [
                    'user_id'   => $user->id,
                    'body'      => $message
                ]
        );

            $thread->addParticipant($recipient->id);
        }
    }
}
