<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Endorsement::class, function (Faker $faker) {
    return [
        'crew_position_id' => factory('App\Models\CrewPosition')->create()->id,
        'endorser_id'      => factory('App\Models\User')->create()->id,
        'endorser_email'   => $faker->email,
        'comment'          => $faker->paragraph,
    ];
});
