<?php

use App\Models\Participant;
use App\Models\Thread;
use App\Models\User;

$factory->define(Participant::class, function () {
    return [
        'thread_id' => factory(Thread::class),
        'user_id'   => factory(User::class),
    ];
});
