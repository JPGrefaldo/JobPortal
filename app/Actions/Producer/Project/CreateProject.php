<?php

namespace App\Actions\Producer\Project;

use App\Models\Project;
use App\Http\Requests\Producer\CreateProjectRequest;

class CreateProject
{
    public function execute(int $user, int $site, CreateProjectRequest $request): Project
    {
        return app(StubProject::class)->create($user, $site, $request);
    }
}