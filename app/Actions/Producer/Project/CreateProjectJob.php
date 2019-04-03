<?php

namespace App\Actions\Producer\Project;

use App\Http\Requests\Producer\CreateProjectJobRequest;
use App\Models\ProjectJob;

class CreateProjectJob
{
    public function execute(CreateProjectJobRequest $request): ProjectJob
    {
        return app(StubProjectJob::class)->create($request);
    }
}
