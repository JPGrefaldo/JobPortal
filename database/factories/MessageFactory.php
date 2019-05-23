<?php

use App\Models\Thread;
use App\Models\User;
use Faker\Generator as Faker;
use App\Models\Message;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'thread_id' => factory(Thread::class),
        'user_id'   => factory(User::class),
        'body'      => $faker->paragraph(),
    ];
});
