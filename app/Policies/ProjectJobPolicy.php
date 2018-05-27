<?php

namespace App\Policies;

use App\Models\ProjectJob;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectJobPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, ProjectJob $job)
    {
        return ($user->id === $job->project->user_id);
    }
}
