<?php

use App\Models\Role;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->jobTitle,
    ];
});
