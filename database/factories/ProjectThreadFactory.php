<?php

use App\Models\Project;
use Cmgmyr\Messenger\Models\Thread;
use Faker\Generator as Faker;

$factory->define(App\ProjectThread::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create()->id,
        'thread_id' => factory(Thread::class)->create(),
    ];
});
