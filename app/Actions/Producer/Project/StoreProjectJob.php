<?php

namespace App\Actions\Producer\Project;

use App\Http\Requests\Producer\CreateProjectJobRequest;
use App\Models\ProjectJob;

class StoreProjectJob
{
    /**
     * @param CreateProjectJobRequest $request
     * @return ProjectJob
     */
    public function execute(CreateProjectJobRequest $request): ProjectJob
    {
        return app(StubProjectJob::class)->create($request);
    }
}
