<?php

namespace App\Actions\Producer\Project;

use App\Http\Requests\Producer\CreateProjectRequest;
use App\Models\Project;

class UpdateProject
{
    /**
     * @param Project $project
     * @param CreateProjectRequest $request
     * @return Project
     */
    public function execute(Project $project, CreateProjectRequest $request): Project
    {
        return app(StubProject::class)->update($project, $request);
    }
}
