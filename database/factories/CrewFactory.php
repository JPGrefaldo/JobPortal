<?php

use App\Models\Crew;
use App\Models\User;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(Crew::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
    ];
});
