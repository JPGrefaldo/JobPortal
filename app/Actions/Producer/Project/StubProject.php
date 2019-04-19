<?php

namespace App\Actions\Producer\Project;

use Illuminate\Support\Arr;
use App\Http\Requests\Producer\CreateProjectRequest;
use App\Models\Project;

class StubProject
{
    /**
     * @param int $user
     * @param int $site
     * @param \App\Http\Requests\Producer\CreateProjectRequest $request
     * @return \App\Models\Project
     */
    public function create(int $user, int $site, CreateProjectRequest $request): Project
    {
        $data = $this->filter($request->toArray());

        $data['user_id'] = $user;
        $data['site_id'] = $site;

        return Project::create($data);
    }

    /**
     * @param \App\Models\Project $project
     * @param \App\Http\Requests\Producer\CreateProjectRequest $request
     * @return \App\Models\Project
     */
    public function update(Project $project, CreateProjectRequest $request): Project
    {
        $data           = $this->filter($request->toArray());
        $data['status'] = 0;

        $project->fill($data);
        $project->save();

        return $project;
    }

    /**
     * @param array $data
     * @return array
     */
    private function filter(array $data): array
    {
        return Arr::only(
            $data,
            [
                'title',
                'production_name',
                'production_name_public',
                'project_type_id',
                'description',
                'location',
            ]
        );
    }
}
