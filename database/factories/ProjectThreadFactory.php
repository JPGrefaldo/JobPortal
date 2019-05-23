<?php

use App\Models\Project;
use App\Models\ProjectThread;
use App\Models\Thread;
use Faker\Generator as Faker;

$factory->define(ProjectThread::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class),
        'thread_id'  => factory(Thread::class),
    ];
});
