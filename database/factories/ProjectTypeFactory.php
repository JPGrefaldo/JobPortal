<?php

use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(\App\Models\ProjectType::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
    ];
});
