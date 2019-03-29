<?php

namespace App\Actions\Producer\Project;

use App\Models\Project;
use App\Http\Requests\Producer\CreateProjectRequest;

class UpdateProject
{
    public function execute(Project $project, CreateProjectRequest $request): Project
    {
        return app(StubProject::class)->update($project, $request);
    }
}