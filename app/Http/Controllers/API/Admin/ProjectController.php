<?php

namespace App\Http\Controllers\API\Admin;

use App\Actions\Admin\DenyProject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DenyProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    public function approve(Project $project)
    {
        $project->approve();

        return response()->json(
            [
                'message' => 'Project approved successfully.',
                'project' => $project,
            ],
            Response::HTTP_OK
        );
    }

    public function unapprove(Project $project)
    {
        $project->unapprove();

        return response()->json(
            [
                'message' => 'Project unapproved successfully.',
                'project' => $project,
            ],
            Response::HTTP_OK
        );
    }

    public function unapproved()
    {
        $projects = ProjectResource::collection(Project::whereStatus(0)->get());

        return response()->json(
            [
                'message'  => 'Successfully fetched all unapproved projects.',
                'projects' => $projects,
            ],
            Response::HTTP_OK
        );
    }

    public function deny(Project $project, DenyProjectRequest $request)
    {
        app(DenyProject::class)->execute($project, $request->reason);

        return response()->json(
            [
                'message'   => 'Successfully denied the project.',
            ],
            Response::HTTP_OK
        );
    }
}
