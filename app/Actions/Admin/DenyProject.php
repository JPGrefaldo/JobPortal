<?php

namespace App\Actions\Admin;

use App\Events\ProjectDenied;
use App\Models\Project;

class DenyProject
{
    
    public function execute(Project $project, String $reason): void
    {
        $project->delete();
        $project->deniedReason()->create([
            'body' => $reason
        ]);

        event(new ProjectDenied($project));
    }
}