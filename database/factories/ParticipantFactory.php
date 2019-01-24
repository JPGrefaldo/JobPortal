<?php

use App\Models\User;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Faker\Generator as Faker;

$factory->define(Participant::class, function (Faker $faker) {
    return [
        'thread_id' => factory(Thread::class),
        'user_id' => factory(User::class),
    ];
});
