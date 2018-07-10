<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CrewPosition::class, function (Faker $faker) {
    return [
        'crew_id'           => factory(App\Models\Crew::class)->create()->id,
        'position_id'       => factory(App\Models\Position::class)->create()->id,
        'details'           => $faker->paragraph,
        'union_description' => $faker->paragraph,
    ];
});
