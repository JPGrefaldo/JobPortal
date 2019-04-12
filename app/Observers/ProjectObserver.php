<?php

namespace App\Observers;

use App\Mail\ProjectApprovalRequestEmail;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;

class ProjectObserver
{
    /**
     * Handle the project "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        $this->sendEmail($project);
    }

    /**
     * Handle the project "updated" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        $isUpdating = true;
        $this->sendEmail($project, $isUpdating);
    }

    /**
     * Handle the project "deleted" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function deleted(Project $project)
    {
        //
    }

    /**
     * Handle the project "restored" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function restored(Project $project)
    {
        //
    }

    /**
     * Handle the project "force deleted" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function forceDeleted(Project $project)
    {
        //
    }

    private function sendEmail(Project $project, $isUpdating=false)
    {
        $admin   = User::role(Role::ADMIN)->first();
        $message = $isUpdating ? 'is recently updated.' : 'is added.';

        if ($admin instanceof User) {
            \Mail::to($admin->email)->send(
                new ProjectApprovalRequestEmail($admin, $message, $project)
            );
        }
    }
}
