<?php

use App\Models\Crew;
use App\Models\CrewSocial;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(CrewSocial::class, function (Faker $faker) {
    return [
        'crew_id'             => factory(Crew::class),
        'url'                 => $faker->unique()->url,
        'social_link_type_id' => 1,
    ];
});
