<?php

namespace App\Listeners;

use App\Events\ManagerDeleted;
use App\Mail\ManagerDeletedEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendManagerDeletedEmail
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
     * @param  ManagerDeleted  $event
     * @return void
     */
    public function handle(ManagerDeleted $event)
    {
        Mail::to($event->manager->email)->send(
            new ManagerDeletedEmail($event->manager, $event->subordinate)
        );
    }
}
