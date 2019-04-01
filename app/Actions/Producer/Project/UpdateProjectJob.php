<?php

namespace App\Actions\Producer\Project;

use App\Models\ProjectJob;
use App\Http\Requests\Producer\CreateProjectJobRequest;

class UpdateProjectJob
{
    public function execute(ProjectJob $projectJob, CreateProjectJobRequest $request): ProjectJob
    {
        return app(StubProjectJob::class)->update($projectJob, $request);
    }
}
