<?php

use App\Models\Department;
use App\Models\Position;
use App\Models\PositionType;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(Position::class, function (Faker $faker) {
    return [
        'name'             => $faker->unique()->words(2, true),
        'department_id'    => factory(Department::class),
        'position_type_id' => factory(PositionType::class),
    ];
});
