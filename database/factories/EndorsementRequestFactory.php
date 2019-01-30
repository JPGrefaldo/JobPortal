<?php

use App\Models\CrewPosition;
use App\Models\EndorsementRequest;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(EndorsementRequest::class, function (Faker $faker) {
    return [
        'crew_position_id' => factory(CrewPosition::class),
        'token' => EndorsementRequest::generateToken(),
    ];
});
