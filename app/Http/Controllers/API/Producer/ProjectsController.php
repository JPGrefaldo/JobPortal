<?php

namespace App\Http\Controllers\API\Producer;

use App\Actions\Producer\Project\CreateProject;
use App\Actions\Producer\Project\CreateProjectJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\ProjectType;
use App\Models\Site;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $projects = $user->projects->paginate();

        return ProjectResource::collection($projects);
    }

    public function projectType()
    {
        $types = ProjectType::all();

        return response()->json([
            'projectType' => $types
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user()->id;
        $site_ids = $request->sites;

        if (count($site_ids) === 1 && $site_ids[0] === 'all'){
            $site_ids = Site::all()->pluck('id');
        }

        foreach ($site_ids as $site_id){
            $project = app(CreateProject::class)->execute($user, $site_id, $request);
        }

        if (isset($project->id) && count($request->project_job) > 0){
            foreach($request->project_job as $job){
                app(CreateProjectJob::class)->execute($job, $project, $request);
            }
        }
    }
}
