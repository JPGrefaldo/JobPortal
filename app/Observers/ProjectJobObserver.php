<?php

namespace App\Observers;

use App\Actions\Mail\SendRushCallEmail;
use App\Models\ProjectJob;

class ProjectJobObserver
{
    /**
     * Handle the project job "created" event.
     *
     * @param  \App\ProjectJob  $projectJob
     * @return void
     */
    public function created(ProjectJob $projectJob)
    {
        app(SendRushCallEmail::class)->execute($projectJob);
    }

    /**
     * Handle the project job "updated" event.
     *
     * @param  \App\ProjectJob  $projectJob
     * @return void
     */
    public function updated(ProjectJob $projectJob)
    {
        //
    }

    /**
     * Handle the project job "deleted" event.
     *
     * @param  \App\ProjectJob  $projectJob
     * @return void
     */
    public function deleted(ProjectJob $projectJob)
    {
        //
    }

    /**
     * Handle the project job "restored" event.
     *
     * @param  \App\ProjectJob  $projectJob
     * @return void
     */
    public function restored(ProjectJob $projectJob)
    {
        //
    }

    /**
     * Handle the project job "force deleted" event.
     *
     * @param  \App\ProjectJob  $projectJob
     * @return void
     */
    public function forceDeleted(ProjectJob $projectJob)
    {
        //
    }
}
