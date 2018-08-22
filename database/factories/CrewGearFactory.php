<?php

use App\Models\Crew;
use Faker\Generator as Faker;

$factory->define(App\Models\CrewGear::class, function (Faker $faker) {
    return [
        'crew_id' => factory(Crew::class)->create()->id,
        'description' => $faker->paragraph,
    ];
});
