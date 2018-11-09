<?php

use App\Models\Crew;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(App\Models\CrewGear::class, function (Faker $faker) {
    static $crew_id;

    return [
        'crew_id'     => $crew_id ?: function () {
            return factory(Crew::class)->create()->id;
        },
        'description' => $faker->paragraph,
    ];
});
