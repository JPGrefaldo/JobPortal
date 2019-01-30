<?php

use Cmgmyr\Messenger\Models\Thread;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'subject' => $faker->name,
    ];
});
