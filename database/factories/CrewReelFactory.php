<?php

use App\Models\Crew;
use App\Models\CrewReel;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(CrewReel::class, function (Faker $faker) {
    return [
        'crew_id' => factory(Crew::class),
        'url'     => $faker->unique()->url,
        'general' => 1,
    ];
});
