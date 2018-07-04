<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Endorsement::class, function (Faker $faker) {
    return [
        'project_job_id' => factory('App\Models\ProjectJob')->create()->id,
        'endorser_id' =>factory('App\Models\User')->create()->id,
        'endorsee_id' => factory('App\Models\User')->create()->id,
    ];
});
