<?php

use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(\App\Models\Department::class, function (Faker $faker) {
    return [
        'name'        => $faker->words(2, true),
        'description' => $faker->sentence,
    ];
});
