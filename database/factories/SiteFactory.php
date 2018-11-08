<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Site::class, function (Faker $faker) {
    $state = $faker->unique()->state;
    return [
        'name' => 'CrewCalls' . $state,
        'hostname' => str_slug($state) . '.crewcalls',
        'forward_to_site_id' => 0,
        'status'             => 1,
    ];
});
