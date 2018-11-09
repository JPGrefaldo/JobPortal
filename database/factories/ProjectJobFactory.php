<?php

use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(\App\Models\ProjectJob::class, function (Faker $faker) {
    return [
        'persons_needed'       => $faker->numberBetween(1, 10),
        'dates_needed'         => $faker->date(),
        'pay_rate'             => $faker->randomFloat(2, 100),
        'notes'                => $faker->paragraph,
        'rush_call'            => $faker->boolean,
        'travel_expenses_paid' => $faker->boolean,
        'gear_provided'        => $faker->sentence,
        'gear_needed'          => $faker->sentence,
        'status'               => 0,
        'project_id'           => function () {
            return factory(\App\Models\Project::class)->create()->id;
        },
        'position_id'          => function () {
            return factory(\App\Models\Position::class)->create()->id;
        },
        'pay_type_id'          => function () {
            return factory(App\Models\PayType::class)->create()->id;
        },
    ];
});