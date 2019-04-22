<?php

namespace App\Actions\Producer\Project;

use App\Models\Project;

class CreateRemoteProject
{
    /**
     * @param \App\Models\Project $project
     * @param array $sites
     */
    public function execute(Project $project, array $sites): void
    {
        $sites = $project->getSitesByIds($sites);
        app(StubRemoteProject::class)->create($project->id, $sites);
    }
}
