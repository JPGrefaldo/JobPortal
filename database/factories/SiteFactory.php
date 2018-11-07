<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Site::class, function (Faker $faker) {
    $state = $faker->unique()->state;
    return [
        'name' => 'CrewCalls' . $state,
        'hostname' => str_slug($state) . '.crewcalls'
    ];
});
