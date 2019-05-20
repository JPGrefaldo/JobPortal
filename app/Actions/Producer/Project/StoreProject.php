<?php

namespace App\Actions\Producer\Project;

use App\Http\Requests\Producer\CreateProjectRequest;
use App\Models\Project;

class StoreProject
{
    /**
     * @param int $user
     * @param int $site
     * @param \App\Http\Requests\Producer\CreateProjectRequest $request
     * @return \App\Models\Project
     */
    public function execute(int $user, int $site, CreateProjectRequest $request): Project
    {
        return app(StubProject::class)->create($user, $site, $request);
    }
}
