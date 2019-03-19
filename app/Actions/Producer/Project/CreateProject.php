<?php

namespace App\Actions\Producer\Project;

use App\Models\Project;

class CreateProject
{
    public function execute(int $user, int $site, array $project): Project
    {
        $data = $this->filter($project);
        
        $data['user_id'] = $user;
        $data['site_id'] = $site;

        return Project::create($data);
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