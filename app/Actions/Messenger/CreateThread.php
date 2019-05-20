<?php

namespace App\Actions\Messenger;

use App\Models\ProjectThread;
use App\Models\User;
use Illuminate\Http\Request;

class CreateThread
{
    public function execute(User $user, Request $request)
    {
        $thread = $user->project()->threads()->save([
            'subject' => $request->subject
        ]);

        ProjectThread::create([
            'project_id' => $user->project->id,
            'thread_id'  => $thread->id
        ]);

        $thread->create([
            'subject' => $request->subject
        ]);

        $thread->addParticipant($request->participant);

        return $thread;
    }
}