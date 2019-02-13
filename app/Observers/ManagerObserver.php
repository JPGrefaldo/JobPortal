<?php

namespace App\Observers;

use App\Mail\ManagerDeletedEmail;
use App\Mail\ManagerConfirmationEmail;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ManagerObserver
{
    public function creating(Manager $manager)
    {
        $subordinate = User::findOrFail($manager->subordinate_id)->first();
        $manager = User::findOrFail($manager->manager_id)->first();

        Mail::to($manager->email)->send(
            new ManagerConfirmationEmail($manager, $subordinate)
        );
    }

    public function deleting(Manager $manager)
    {
        $subordinate = User::findOrFail($manager->subordinate_id)->first();
        $manager = User::findOrFail($manager->manager_id)->first();

        Mail::to($manager->email)->send(
            new ManagerDeletedEmail($event->manager, $event->subordinate)
        );
    }
}