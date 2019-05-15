<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Thread as Model;

class Thread extends Model
{
    /**
     * @param $project
     * @param $participant
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public static function getByProjectAndParticipant(Project $project, User $participant)
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
