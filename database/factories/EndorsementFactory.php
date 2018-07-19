<?php

use App\Models\CrewPosition;
use App\Models\Endorsement;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\Endorsement::class, function (Faker $faker) {
    return [
        'crew_position_id' => factory(CrewPosition::class)->create()->id,
        'endorser_name'    => $faker->name,
        'endorser_email'   => $faker->email,
        'token' => Endorsement::generateToken(),
    ];
});

$factory->state(App\Models\Endorsement::class, 'approved', function (Faker $faker) {
    return [
        'approved_at' => Carbon::now(),
        'comment'     => $faker->paragraph,
    ];
});

$factory->state(App\Models\Endorsement::class, 'deleted', function (Faker $faker) {
    return [
        'deleted' => true,
    ];
});
