<?php

use App\Models\Message;
use App\Models\PendingFlagMessage;
use Faker\Generator as Faker;

$factory->define(PendingFlagMessage::class, function (Faker $faker) {
    return [
        'message_id' => factory(Message::class),
        'reason'     => $faker->paragraph,
    ];
});
