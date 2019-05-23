<?php

use App\Models\PendingFlagMessage;
use Faker\Generator as Faker;
use App\Models\Message;

$factory->define(PendingFlagMessage::class, function (Faker $faker) {
    return [
        'message_id' => factory(Message::class),
        'reason'     => $faker->paragraph,
    ];
});
