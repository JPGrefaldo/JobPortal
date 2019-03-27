<?php

namespace App\Actions\Producer\Project;

use App\Models\Project;

class CreateRemoteProject {

    public function execute(Project $project, array $sites): void
    {
        $sites = $project->getSitesById($sites);
        app(StubRemoteProject::class)->create($project->id, $sites->toArray());
    }
}