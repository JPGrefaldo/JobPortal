<?php

namespace App\Actions\Producer\Project;

use App\Models\ProjectJob;
use App\Http\Requests\Producer\CreateProjectJobRequest;

class CreateProjectJob
{
    public function execute(CreateProjectJobRequest $request): ProjectJob
    {
        return app(StubProjectJob::class)->create($request);
    }
}
