<?php

namespace App\Actions\Producer\Project;

use App\Models\Project;

class UpdateProject
{
    public function execute(Project $project, $request): Project
    {
        return app(StubProject::class)->update($project, $request);
    }
}