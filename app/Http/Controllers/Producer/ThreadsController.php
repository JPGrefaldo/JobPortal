<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ThreadsController extends Controller
{
    // TODO: check ownership of project
    public function index(Project $project)
    {
        return $project->threads;
    }
}
