<?php

use App\Models\PayType;
use App\Models\Position;
use App\Models\Project;
use App\Models\ProjectJob;
use Faker\Generator as Faker;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(ProjectJob::class, function (Faker $faker) {
    return [
        'persons_needed'       => $faker->numberBetween(1, 10),
        'dates_needed'         => $faker->date(),
        'pay_rate'             => $faker->numberBetween(2, 100),
        'notes'                => $faker->paragraph,
        'rush_call'            => $faker->boolean,
        'travel_expenses_paid' => $faker->boolean,
        'gear_provided'        => $faker->sentence,
        'gear_needed'          => $faker->sentence,
        'status'               => 0,
        'project_id'           => factory(Project::class),
        'position_id'          => factory(Position::class),
        'pay_type_id'          => factory(PayType::class),
    ];
});
