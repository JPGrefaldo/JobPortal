<?php

namespace App\Actions\Producer\Project;

use App\Models\Project;

class UpdateProject
{
    public function execute(array $project): Project
    {
        $data = $this->filter($project);
        
        $project = Project::where('id', $project['id'])->first();
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