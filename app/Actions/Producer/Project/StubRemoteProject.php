<?php

namespace App\Actions\Producer\Project;

use App\Models\RemoteProject;
use Carbon\Carbon;

class StubRemoteProject
{
    /**
     * @param int $project
     * @param $sites
     */
    public function create(int $project, $sites): void
    {
        $data = $this->format($project, $sites);

        RemoteProject::insert($data);
    }

    /**
     * @param int $project
     * @param $sites
     */
    public function update(int $project, $sites): void
    {
        $data = $this->format($project, $sites);

        $this->delete($project);
        RemoteProject::insert($data);
    }

    /**
     * @param int $project
     */
    public function delete(int $project)
    {
        RemoteProject::where('project_id', $project)->delete();
    }

    /**
     * @param int $project
     * @param array $sites
     * @return array
     */
    private function format(int $project, $sites): array
    {
        $data = [];

        foreach ($sites as $site) {
            array_push($data, [
                'project_id' => $project,
                'site_id'    => $site,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        return $data;
    }
}
