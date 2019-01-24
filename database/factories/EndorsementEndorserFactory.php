<?php

use App\Models\EndorsementEndorser;
use App\Models\User;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(EndorsementEndorser::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'email'   => $faker->email,
    ];
});

$factory->state(EndorsementEndorser::class, 'isUser', function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'email'   => null,
    ];
});

$factory->state(EndorsementEndorser::class, 'notUser', function (Faker $faker) {
    return [
        'user_id' => null,
        'email'   => $faker->email,
    ];
});
