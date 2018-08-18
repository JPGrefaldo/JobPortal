<?php

use App\Models\CrewPosition;
use App\Models\EndorsementRequest;
use Faker\Generator as Faker;

$factory->define(App\Models\EndorsementRequest::class, function (Faker $faker) {
    return [
        'crew_position_id' => factory(CrewPosition::class)->create()->id,
        'token' => EndorsementRequest::generateToken(),
    ];
});
