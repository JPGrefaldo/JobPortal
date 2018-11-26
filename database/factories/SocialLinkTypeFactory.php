<?php

use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(App\Models\SocialLinkType::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
        'image' => 'photos/' . $faker->uuid . '/' . $faker->sha1 . '.png',
    ];
});
