<?php

use App\Models\Site;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(Site::class, function (Faker $faker) {
    $state = $faker->unique()->state;
    return [
        'name'               => 'CrewCalls' . $state,
        'hostname'           => Str::slug($state) . '.crewcalls',
        'forward_to_site_id' => 0,
        'status'             => 1,
    ];
});
