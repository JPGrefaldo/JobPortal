<?php

namespace App\Actions\Messenger;

use App\Models\Project;
use App\Models\ProjectThread;
use App\Models\Thread;

class StoreThread
{
    public function execute(Project $project, String $subject): Thread
    {
        $thread = $project->threads()->create([
            'subject' => $subject
        ]);

        ProjectThread::create([
            'project_id' => $project->id,
            'thread_id'  => $thread->id
        ]);

        return $thread;
    }
}
