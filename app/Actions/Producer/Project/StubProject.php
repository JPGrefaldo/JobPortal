<?php

namespace App\Actions\Producer\Project;

use App\Http\Requests\Producer\CreateProjectRequest;
use App\Models\Project;
use Illuminate\Support\Arr;

class StubProject
{
    /**
     * @param int $user
     * @param int $site
     * @param CreateProjectRequest $request
     * @return Project
     */
    public function create(int $user, int $site, CreateProjectRequest $request): Project
    {
        $data = $this->filter($request->toArray());

        $data['user_id'] = $user;
        $data['site_id'] = $site;

        return Project::create($data);
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

    /**
     * @param Project $project
     * @param CreateProjectRequest $request
     * @return Project
     */
    public function update(Project $project, CreateProjectRequest $request): Project
    {
        $data = $this->filter($request->toArray());
        $data['status'] = 0;

        $project->fill($data);
        $project->save();

        return $project;
    }
}
