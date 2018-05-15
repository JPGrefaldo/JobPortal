<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\CreateProjectRequest;
use App\Services\Producer\ProjectsServices;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    public function store(CreateProjectRequest $request)
    {
        $input = $request->validated();

        app(ProjectsServices::class)->processCreate($input, Auth::user());
    }
}
