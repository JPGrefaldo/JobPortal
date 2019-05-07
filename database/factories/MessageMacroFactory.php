<?php
use App\Models\MessageMacro;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(MessageMacro::class, function(Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'message' => $faker->paragraph()
    ];
});