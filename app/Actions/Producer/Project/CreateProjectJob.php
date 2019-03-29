<?php

namespace App\Actions\Producer\Project;

use App\Models\ProjectJob;

class CreateProjectJob
{
    public function execute(CreateProjectRequest $request): ProjectJob
    {
        return app(StubProjectJob::class)->create($request);
    }
}
