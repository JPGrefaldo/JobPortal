<?php

namespace App\Actions\Producer\Project;

use App\Http\Requests\Producer\CreateProjectJobRequest;
use App\Models\ProjectJob;

class StoreProjectJob
{
    /**
     * @param \App\Http\Requests\Producer\CreateProjectJobRequest $request
     * @return \App\Models\ProjectJob
     */
    public function execute(CreateProjectJobRequest $request): ProjectJob
    {
        return app(StubProjectJob::class)->create($request);
    }
}
