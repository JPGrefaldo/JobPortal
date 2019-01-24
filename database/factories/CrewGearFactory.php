<?php

use App\Models\Crew;
use App\Models\CrewGear;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(CrewGear::class, function (Faker $faker) {
    return [
        'crew_id'     =>  factory(Crew::class),
        'description' => $faker->unique()->paragraph,
    ];
});
