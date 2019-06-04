<?php

namespace App\Listeners;

use App\Events\ProjectDenied;
use App\Mail\ProjectDeniedEmail;
use Illuminate\Support\Facades\Mail;

class SendProjectDeniedEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ProjectDenied $event
     * @return void
     */
    public function handle(ProjectDenied $event)
    {
        $producer = $event->project->owner()->first();
        Mail::to($producer->email)->send(
            new ProjectDeniedEmail($producer, $event->project)
        );
    }
}
