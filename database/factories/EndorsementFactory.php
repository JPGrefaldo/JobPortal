<?php

use App\Models\Crew;
use Carbon\Carbon;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(App\Models\Endorsement::class, function (Faker $faker) {
    static $endorsement_request_id;

    return [
        'endorsement_request_id' => $endorsement_request_id ?: function () {
            return factory(\App\Models\EndorsementRequest::class)->create()->id;
        },
        'endorser_name'          => $faker->name,
        'endorser_email'         => $faker->email,
    ];
});

$factory->state(App\Models\Endorsement::class, 'approved', function (Faker $faker) {
    $crew = factory(Crew::class)->create();

    return [
        'endorser_id'    => $crew->id,
        'endorser_name'  => '',
        'endorser_email' => '',
        'approved_at'    => Carbon::now(),
    ];
});

$factory->state(App\Models\Endorsement::class, 'withComment', function (Faker $faker) {
    return [
        'comment' => $faker->paragraph,
    ];
});
