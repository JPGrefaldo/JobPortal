<?php

use App\Models\User;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'thread_id' => factory(Thread::class),
        'user_id' => factory(User::class),
        'body' => $faker->paragraph(),
    ];
});
