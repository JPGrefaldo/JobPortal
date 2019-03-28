<?php

namespace App\Actions\Producer\Project;

use App\Models\Project;

class StubProject
{
    public function create(int $user, int $site, $request): Project
    {
        $data = $this->filter($request->toArray());
        
        $data['user_id'] = $user;
        $data['site_id'] = $site;

        return Project::create($data);
    }

    public function update(Project $project, $request): Project
    {
        $data = $this->filter($request->toArray());
        
        $project->update($data);
        return $project;
    }

    private function filter(array $data): array
    {
        return array_only($data,
            [
                'title',
                'production_name',
                'production_name_public',
                'project_type_id',
                'description',
                'location'
            ]
        );
    }
}