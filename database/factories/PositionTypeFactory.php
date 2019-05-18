<?php

use App\Models\PositionType;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(PositionType::class, function (Faker $faker) {
    return [
        'name'        => $faker->unique()->words(2, true),
        'description' => $faker->sentence,
    ];
});
