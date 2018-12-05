<?php

use App\Models\User;
use Cmgmyr\Messenger\Models\Thread;
use Faker\Generator as Faker;

$factory->define(Cmgmyr\Messenger\Models\Message::class, function (Faker $faker) {
    static $thread_id;

    return [
        'thread_id' => $thread_id ?: function () {
            return factory(Thread::class)->create();
        },
        'user_id' => factory(User::class)->create(),
        'body' => $faker->paragraph(),
    ];
});
