<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ThreadsController extends Controller
{
    public function index(Project $project)
    {
        return $project->threads;
    }
}
