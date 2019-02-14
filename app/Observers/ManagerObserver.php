<?php

namespace App\Observers;

use App\Mail\ManagerDeletedEmail;
use App\Mail\ManagerConfirmationEmail;
use App\Models\Manager;
use App\Models\User;

class ManagerObserver
{
    public function created(Manager $manager)
    {
        $this->sendMailable($manager, ManagerConfirmationEmail::class);
    }

    public function deleted(Manager $manager)
    {
        $this->sendMailable($manager, ManagerDeletedEmail::class);
    }

    private function sendMailable(Manager $manager, $mailable)
    {
        $subordinate = User::findOrFail($manager->subordinate_id)->first();
        $manager = User::findOrFail($manager->manager_id)->first();

        \Mail::to($manager->email)->send(
            new $mailable($manager, $subordinate)
        );
    }
}