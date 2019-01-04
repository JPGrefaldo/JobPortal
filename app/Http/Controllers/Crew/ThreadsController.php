<?php

namespace App\Http\Controllers\Crew;

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
