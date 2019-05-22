<?php

use App\Models\Participant;
use App\Models\Thread;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Participant::class, function (Faker $faker) {
    return [
        'thread_id' => factory(Thread::class),
        'user_id'   => factory(User::class),
    ];
});
