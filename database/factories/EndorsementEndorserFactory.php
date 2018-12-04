<?php

use App\Models\Crew;
use Carbon\Carbon;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(App\Models\EndorsementEndorser::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'email'   => $faker->email,
    ];
});

$factory->state(App\Models\EndorsementEndorser::class, 'isUser', function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'email'   => null,
    ];
});

$factory->state(App\Models\EndorsementEndorser::class, 'notUser', function (Faker $faker) {
    return [
        'user_id' => null,
        'email'   => $faker->email,
    ];
});

