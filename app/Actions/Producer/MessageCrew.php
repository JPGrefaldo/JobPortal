<?php

namespace App\Actions\Admin;

use App\Models\Project;
use App\Models\User;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;

class MessageCrew
{
    public function execute($data, Project $project, User $user)
    {
        $recipients = User::whereIn('hash_id', $data['recipients'])->get();

        foreach ($recipients as $recipient) {
            $thread = $this->getThread($project, $recipient);

            if ($thread === null) {
                $thread = Thread::create([
                    'subject' => $recipient->fullName,
                ]);
                $project->threads()->attach($thread);
                $thread->addParticipant([$user->id, $recipient->id]);
            }

            $thread->messages()->save(new Message([
                'user_id' => $user->id,
                'body' => $data['message'],
            ]));

            // TODO: queue send emails
        }
    }

    public function getThread($project, $participant)
    {
        return Thread::query()
            ->join('project_thread', 'threads.id', 'project_thread.thread_id')
            ->join('projects', 'project_thread.project_id', 'projects.id')
            ->join('participants', 'threads.id', 'participants.thread_id')
            ->where('projects.id', $project->id)
            ->where('participants.user_id', $participant->id)
            ->first();
    }
}
