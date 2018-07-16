<?php

use App\Models\CrewPosition;
use Faker\Generator as Faker;

$factory->define(App\Models\Endorsement::class, function (Faker $faker) {
    return [
        'crew_position_id' => factory(CrewPosition::class)->create()->id,
        'endorser_email'   => $faker->email,
        'approved_at'      => '',
        'comment'          => $faker->paragraph,
        'deleted'          => $faker->boolean,
        'approved_date'    => $faker->optional()->Carbon::now(),
    ];
});
