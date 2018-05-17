<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\CreateProjectRequest;
use App\Services\Producer\ProjectsServices;

class ProjectsController extends Controller
{
    public function store(CreateProjectRequest $request)
    {
        $input = $request->validated();

        app(ProjectsServices::class)->create(
            $request->validated(),
            auth()->user(),
            session('site')
        );
    }
}
