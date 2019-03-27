<?php

namespace App\Actions\Producer\Project;

use App\Models\ProjectJob;

class UpdateProjectJob
{
    public function execute(ProjectJob $projectJob, array $request): ProjectJob
    {
        return app(StubProjectJob::class)->update($projectJob, $request);
    }
}
