<?php

use App\Models\Project;
use App\Models\ProjectThread;
use App\Models\Thread;

$factory->define(ProjectThread::class, function () {
    return [
        'project_id' => factory(Project::class),
        'thread_id'  => factory(Thread::class),
    ];
});
