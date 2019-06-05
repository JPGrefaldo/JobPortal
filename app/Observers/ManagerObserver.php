<?php

namespace App\Observers;

use App\Mail\ManagerConfirmationEmail;
use App\Mail\ManagerDeletedEmail;
use App\Models\Manager;
use App\Models\User;
use Mail;

class ManagerObserver
{
    public function created(Manager $manager)
    {
        $this->sendMailable($manager, ManagerConfirmationEmail::class);
    }

    private function sendMailable(Manager $manager, $mailable)
    {
        $subordinate = User::findOrFail($manager->subordinate_id);
        $manager = User::findOrFail($manager->manager_id);

        Mail::to($manager->email)->send(
            new $mailable($manager, $subordinate)
        );
    }

    public function deleted(Manager $manager)
    {
        $this->sendMailable($manager, ManagerDeletedEmail::class);
    }
}
