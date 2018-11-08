<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(App\Models\CrewReel::class, function (Faker $faker) {
    return [
        'crew_id' => function () {
            return factory(\App\Models\Crew::class)->create()->id;
        },
        'url'     => $faker->url,
        'general' => 1,
    ];
});

$factory->define(App\Models\CrewSocial::class, function (Faker $faker) {
    return [
        'crew_id'             => function () {
            return factory(\App\Models\Crew::class)->create()->id;
        },
        'url'                 => $faker->url,
        'social_link_type_id' => 1,
    ];
});

$factory->define(\App\Models\Department::class, function (Faker $faker) {
    return [
        'name'        => $faker->words(2, true),
        'description' => $faker->sentence,
    ];
});

$factory->define(\App\Models\PositionTypes::class, function (Faker $faker) {
    return [
        'name'        => $faker->words(2, true),
        'description' => $faker->sentence,
    ];
});


$factory->define(\App\Models\PayType::class, function ($faker) {
    return [
        'name'     => $faker->word,
        'has_rate' => $faker->boolean,
    ];
});


