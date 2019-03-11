<?php

use App\Models\SocialLinkType;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

// TODO: restructure image, must include user hash id
$factory->define(SocialLinkType::class, function (Faker $faker) {
    return [
        'name'  => $faker->unique()->company,
        'image' => 'photos/' . $faker->uuid . '/' . $faker->sha1 . '.png',
    ];
});
