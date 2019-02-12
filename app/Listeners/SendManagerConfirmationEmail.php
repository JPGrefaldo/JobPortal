<?php

namespace App\Listeners;

use App\Events\ManagerAdded;
use App\Mail\ManagerConfirmationEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendManagerConfirmationEmail
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
     * @param  ManagerAdded  $event
     * @return void
     */
    public function handle(ManagerAdded $event)
    {
        \Mail::to($event->manager->email)->send(
            new ManagerConfirmationEmail($event->manager, $event->subordinate)
        );
    }
}
