<?php

use App\Models\CrewPosition;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(CrewPosition::class, function (Faker $faker) {
    return [
        'crew_id'           => factory(App\Models\Crew::class),
        'position_id'       => factory(App\Models\Position::class),
        'details'           => $faker->paragraph,
        'union_description' => $faker->paragraph,
    ];
});
