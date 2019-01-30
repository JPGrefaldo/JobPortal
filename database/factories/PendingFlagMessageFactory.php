<?php

use App\Models\PendingFlagMessage;
use Cmgmyr\Messenger\Models\Message;
use Faker\Generator as Faker;

$factory->define(PendingFlagMessage::class, function (Faker $faker) {
    return [
        'message_id' => factory(Message::class),
        'reason' => $faker->paragraph,
    ];
});
