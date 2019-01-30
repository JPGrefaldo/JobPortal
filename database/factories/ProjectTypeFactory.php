<?php

use App\Models\ProjectType;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(ProjectType::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->words(2, true),
    ];
});
