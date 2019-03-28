<?php

namespace App\Actions\Producer\Project;

use App\Models\Project;

class CreateProject
{
    public function execute(int $user, int $site, $request): Project
    {
        return app(StubProject::class)->create($user, $site, $request);
    }
}