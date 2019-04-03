<?php

namespace App\Actions\Producer\Project;

use App\Http\Requests\Producer\CreateProjectRequest;
use App\Models\Project;

class CreateProject
{
    public function execute(int $user, int $site, CreateProjectRequest $request): Project
    {
        return app(StubProject::class)->create($user, $site, $request);
    }
}
