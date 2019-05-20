<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\MessageTemplate;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(MessageTemplate::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'message' => $faker->paragraph(),
    ];
});
