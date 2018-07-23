<?php

use App\EndorsementRequest;
use App\Models\CrewPosition;
use Faker\Generator as Faker;

$factory->define(App\EndorsementRequest::class, function (Faker $faker) {
    return [
        'crew_position_id' => factory(CrewPosition::class)->create()->id,
        'token' => EndorsementRequest::generateToken(),
    ];
});
