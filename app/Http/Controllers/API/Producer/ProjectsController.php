<?php

namespace App\Http\Controllers\API\Producer;

use App\Actions\Producer\Project\CreateProject;
use App\Actions\Producer\Project\CreateRemoteProject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\CreateProjectRequest;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Response;
use App\Models\Site;
use App\Utils\UrlUtils;

class ProjectsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $projects = $user->projects->paginate();

        return ProjectResource::collection($projects);
    }

    public function store(CreateProjectRequest $request)
    {   
        $user = auth()->user()->id;
        $site_id = $this->getHostSiteID();

        $project = app(CreateProject::class)->execute($user, $site_id, $request->toArray());

        if (! isset($project->id)){
            return response()->json([
                    'message', 'Unable to save the project. Please try again'
                ], 
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        app(CreateRemoteProject::class)->execute($project, $request->remotes);

        return response()->json([
                'message' => 'Project successfully added',
                'project' => $project->load('remotes')
            ], Response::HTTP_CREATED
        );
    }

    public function show(Project $project)
    {
        return response()->json([
                'project' => $project->load(['jobs', 'remotes'])
            ], 
            Response::HTTP_OK
        );
    }

    private function getHostSiteID()
    {
        $hostname = UrlUtils::getHostNameFromBaseUrl(request()->getHttpHost());
        $site = Site::where('hostname', $hostname)->first()->pluck('id');
        return $site[0];
    }
}
