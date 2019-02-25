<?php

namespace App\Models;

use App\User;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;

class ThreadParticipant extends Participant
{
    public function __construct()
    {
        parent::__construct();
    }

    public function users()
    {
        return $this->belongsToMany(Thread::class, 'thread_id')
                    ->using(User::class)
                    ->as('users')
                    ->withPivot('users');
    }
}
