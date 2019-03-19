<?php

namespace App\Actions\Producer\Project;

use App\Models\Project;

class CreateRemoteProject {

    public function execute(Project $project, array $sites): void
    {
        $sites = $project->getSitesById($sites);

        foreach ($sites as $site){
            app(StubRemoteProject::class)->execute($project->id, $site);
        }
    }
}