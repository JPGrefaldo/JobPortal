<?php

namespace App\Actions\Producer\Project;

use App\Models\RemoteProject;

class StubRemoteProject {

    public function execute($project_id, $site_id): RemoteProject
    {
        return RemoteProject::create([
            'project_id' => $project_id,
            'site_id' => $site_id
        ]);
    }
}