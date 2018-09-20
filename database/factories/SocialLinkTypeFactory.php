<?php

use Faker\Generator as Faker;

$factory->define(App\Models\SocialLinkType::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'image' => 'photos/' . $faker->uuid . '/' . $faker->sha1 . '.png',
    ];
});
