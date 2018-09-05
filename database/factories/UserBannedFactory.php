<?php

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(App\Models\UserBanned::class, function (Faker $faker) {
    static $user_id;

    return [
        'user_id' => factory(User::class)->create()->id,
        'reason' => $faker->paragraph,
    ];
});

// $factory->state(App\Models\UserBanned::class, 'withUser', function (Faker $faker) {
//     return [
//         'user_id' => factory(User::class)->create()->id,
//     ];
// });
