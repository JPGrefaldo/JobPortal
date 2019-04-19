<?php

namespace App\Actions\Producer\Project;

use App\Http\Requests\Producer\CreateProjectJobRequest;
use App\Models\ProjectJob;

class UpdateProjectJob
{
    /**
     * @param \App\Models\ProjectJob $projectJob
     * @param \App\Http\Requests\Producer\CreateProjectJobRequest $request
     * @return \App\Models\ProjectJob
     */
    public function execute(ProjectJob $projectJob, CreateProjectJobRequest $request): ProjectJob
    {
        return app(StubProjectJob::class)->update($projectJob, $request);
    }
}
