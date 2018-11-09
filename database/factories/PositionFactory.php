<?php

use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(App\Models\Position::class, function (Faker $faker) {
    static $department_id;

    return [
        'name'             => $faker->words(2, true),
        'department_id'    => $department_id ?: function () {
            return factory(\App\Models\Department::class)->create()->id;
        },
        'position_type_id' => $department_id ?: function () {
            return factory(\App\Models\PositionTypes::class)->create()->id;
        },
    ];
});
