<?php

use Faker\Generator as Faker;

$factory->define(Cmgmyr\Messenger\Models\Thread::class, function (Faker $faker) {
    return [
        'subject' => $faker->name,
    ];
});
