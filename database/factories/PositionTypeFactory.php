<?php

use App\Models\PositionTypes;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(PositionTypes::class, function (Faker $faker) {
    return [
        'name'        => $faker->unique()->words(2, true),
        'description' => $faker->sentence,
    ];
});
