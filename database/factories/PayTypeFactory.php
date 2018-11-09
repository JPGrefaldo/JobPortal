<?php

use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(\App\Models\PayType::class, function (Faker $faker) {
    return [
        'name'     => $faker->word,
        'has_rate' => $faker->boolean,
    ];
});


