<?php

use App\EndorsementRequest;
use App\Models\Endorsement;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\Endorsement::class, function (Faker $faker) {
    return [
        'endorsement_request_id' => factory(EndorsementRequest::class)->create()->id,
        'endorser_name'          => $faker->name,
        'endorser_email'         => $faker->email,
    ];
});

$factory->state(App\Models\Endorsement::class, 'approved', function (Faker $faker) {
    $user = factory(User::class)->create();
    return [
        'endorser_id'    => $user->id,
        'endorser_name'  => "$user->first_name $user->last_name",
        'endorser_email' => $user->email,
        'approved_at'    => Carbon::now(),
    ];
});

$factory->state(App\Models\Endorsement::class, 'withComment', function (Faker $faker) {
    return [
        'comment' => $faker->paragraph,
    ];
});
