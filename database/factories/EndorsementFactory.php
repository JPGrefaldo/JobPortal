<?php

use App\Models\Crew;
use App\Models\Endorsement;
use Carbon\Carbon;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(Endorsement::class, function (Faker $faker) {
    return [
        'endorsement_request_id' => factory(\App\Models\EndorsementRequest::class),
        'endorser_name'          => $faker->unique()->name,
        'endorser_email'         => $faker->unique()->email,
    ];
});

$factory->state(Endorsement::class, 'approved', function (Faker $faker) {
    return [
        'endorser_id'    => factory(Crew::class)->create(),
        'endorser_name'  => '',
        'endorser_email' => '',
        'approved_at'    => Carbon::now(),
    ];
});

$factory->state(Endorsement::class, 'withComment', function (Faker $faker) {
    return [
        'comment' => $faker->unique()->paragraph,
    ];
});
