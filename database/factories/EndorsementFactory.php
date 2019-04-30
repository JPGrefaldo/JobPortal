<?php

use App\Models\Endorsement;
use Carbon\Carbon;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(Endorsement::class, function (Faker $faker) {
    return [
        'endorsement_request_id' => function () {
            return factory(\App\Models\EndorsementRequest::class)->create()->id;
        },
        'approved_at'            => Carbon::now(),
    ];
});
