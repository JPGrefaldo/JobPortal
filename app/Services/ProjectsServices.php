<?php


namespace App\Services;


use App\Models\Project;

class ProjectsServices
{
    /**
     * @param array $data
     *
     * @return \App\Models\Project
     */
    public function create(array $data)
    {
        return Project::create($data);
    }
}
