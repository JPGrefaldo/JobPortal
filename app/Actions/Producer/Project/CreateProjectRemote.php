<?php

namespace App\Actions\Producer\Project;

use App\Models\RemoteProject;

class CreateProjectRemote {

    public function execute($project_id, $site_id)
    {
        RemoteProject::create([
            'project_id' => $project_id,
            'site_id' => $site_id
        ]);
    }
}