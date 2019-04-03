<?php

namespace App\Actions\Producer\Project;

use App\Http\Requests\Producer\CreateProjectRequest;
use App\Models\Project;

class UpdateProject
{
    public function execute(Project $project, CreateProjectRequest $request): Project
    {
        return app(StubProject::class)->update($project, $request);
    }
}
