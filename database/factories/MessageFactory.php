<?php

use App\Models\User;
use Cmgmyr\Messenger\Models\Thread;
use Faker\Generator as Faker;

$factory->define(Cmgmyr\Messenger\Models\Message::class, function (Faker $faker) {
    return [
        'thread_id' => factory(Thread::class)->create(),
        'user_id' => factory(User::class)->create(),
        'body' => $faker->paragraph(),
    ];
});
