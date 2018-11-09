<?php

use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(App\Models\CrewReel::class, function (Faker $faker) {
    return [
        'crew_id' => function () {
            return factory(\App\Models\Crew::class)->create()->id;
        },
        'url'     => $faker->url,
        'general' => 1,
    ];
});