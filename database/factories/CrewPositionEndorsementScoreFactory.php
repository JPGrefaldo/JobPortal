<?php

use App\Models\CrewPosition;
use App\Models\CrewPositionEndorsementScore;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(CrewPositionEndorsementScore::class, function (Faker $faker) {
    $rand = [
        '50',
        '40',
        '30',
        '20',
    ];

    return [
        'crew_position_id' => factory(CrewPosition::class),
        'score'            => $faker->randomElement([0, 1, 2, 3]),
    ];
});