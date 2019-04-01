<?php

namespace App\Actions\Producer\Project;

use App\Models\Project;

class CreateProject
{
    public function execute($user, $site_id, $request)
    {
        return Project::create([
                    'user_id' => $user,
                    'site_id' => $site_id,
                    'title' => $request->title,
                    'production_name' => $request->production_name,
                    'production_name_public' => $request->production_name_public,
                    'project_type_id' => $request->type_id,
                    'description' => $request->description,
                    'location' => $request->location
                ]);
    }
}