<?php

use App\Models\User;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(App\Models\UserBanned::class, function (Faker $faker) {
    static $user_id;

    return [
        'user_id' => factory(User::class)->create()->id,
        'reason' => $faker->unique()->paragraph,
    ];
});
