<?php

namespace App\Actions\Producer\Project;

use App\Http\Requests\Producer\CreateProjectJobRequest;
use App\Models\ProjectJob;

class UpdateProjectJob
{
    /**
     * @param ProjectJob $projectJob
     * @param CreateProjectJobRequest $request
     * @return ProjectJob
     */
    public function execute(ProjectJob $projectJob, CreateProjectJobRequest $request): ProjectJob
    {
        return app(StubProjectJob::class)->update($projectJob, $request);
    }
}
