<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Thread as VendorThread;

class Thread extends VendorThread
{
    /**
     * @param $project
     * @param $participant
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public static function getByProjectAndParticipant(Project $project, User $participant)
    {
        return self::query()
            ->join('project_thread', 'threads.id', 'project_thread.thread_id')
            ->join('projects', 'project_thread.project_id', 'projects.id')
            ->join('participants', 'threads.id', 'participants.thread_id')
            ->where('projects.id', $project->id)
            ->where('participants.user_id', $participant->id)
            ->first();
    }
}
