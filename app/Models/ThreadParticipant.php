<?php

namespace App\Models;

use App\User;
use Cmgmyr\Messenger\Models\Participant as VendorParticipant;

class ThreadParticipant extends VendorParticipant
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(Thread::class, 'thread_id')
            ->using(User::class)
            ->as('users')
            ->withPivot('users');
    }
}
