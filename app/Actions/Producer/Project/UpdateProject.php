<?php

namespace App\Actions\Producer\Project;

use App\Http\Requests\Producer\CreateProjectRequest;
use App\Models\Project;

class UpdateProject
{
    /**
     * @param \App\Models\Project $project
     * @param \App\Http\Requests\Producer\CreateProjectRequest $request
     * @return \App\Models\Project
     */
    public function execute(Project $project, CreateProjectRequest $request): Project
    {
        return app(StubProject::class)->update($project, $request);
    }
}
