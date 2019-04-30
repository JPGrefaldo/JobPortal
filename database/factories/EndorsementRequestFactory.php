<?php

use App\Models\EndorsementRequest;
use App\Utils\StrUtils;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(EndorsementRequest::class, function (Faker $faker) {
    return [
        'endorsement_endorser_id'  => function () {
            return factory(\App\Models\EndorsementEndorser::class)->create()->id;
        },
        'token'                    => StrUtils::createRandomString(),
        'message'                  => $faker->text(),
    ];
});
