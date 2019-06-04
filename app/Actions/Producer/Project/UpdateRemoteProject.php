<?php

namespace App\Actions\Producer\Project;

use App\Models\Project;

class UpdateRemoteProject
{
    /**
     * @param Project $project
     * @param array $sites
     */
    public function execute(Project $project, array $sites): void
    {
        $sites = $project->getSitesByIds($sites);
        app(StubRemoteProject::class)->update($project->id, $sites);
    }
}
