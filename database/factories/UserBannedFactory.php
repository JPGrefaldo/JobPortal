<?php

use App\Models\User;
use App\Models\UserBanned;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(UserBanned::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'reason'  => $faker->unique()->paragraph,
    ];
});
