<?php

namespace App\Actions\Producer\Project;

use App\Models\RemoteProject;
use Carbon\Carbon;

class StubRemoteProject {

    public function create(int $project_id, array $sites): void
    {
        $data = $this->format($project_id, $sites);

        RemoteProject::insert($data);
    }

    public function update(int $project_id, array $sites) : void
    {
        $data = $this->format($project_id, $sites);

        RemoteProject::where('project_id', $project_id)->delete();
        RemoteProject::insert($data);
    }

    private function format($project_id, $sites)
    {
        $data = [];

        foreach ($sites as $site){
            array_push($data, [
                'project_id' => $project_id,
                'site_id' => $site,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return $data;
    }
}