<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ThreadResource;
use App\Models\Project;

class ThreadsController extends Controller
{
    public function index(Project $project)
    {
        $threads = $project->threads()
                            ->latest('updated_at')
                            ->get();

        return ThreadResource::collection($threads);
    }
}
