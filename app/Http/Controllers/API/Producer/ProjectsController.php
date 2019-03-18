<?php

namespace App\Http\Controllers\API\Producer;

use App\Actions\Producer\Project\CreateProject;
use App\Actions\Producer\Project\CreateProjectJob;
use App\Actions\Producer\Project\CreateProjectRemote;
use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\CreateProjectRequest;
use App\Http\Resources\ProjectResource;
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

        $project = app(CreateProject::class)->execute($user, $site_id, $request);

        if (isset($project->id) && count($request->jobs) > 0){
            
            foreach($request->jobs as $job){
                app(CreateProjectJob::class)->execute($job, $project);

                $site_ids = $project->siteIDs($job['sites']);

                foreach ($site_ids as $site_id){
                    app(CreateProjectRemote::class)->execute($project->id, $site_id);
                }
            }
        }

        return response()->json([
            'message' => 'Project successfully added'
        ]);
    }

    private function getHostSiteID()
    {
        $hostname = UrlUtils::getHostNameFromBaseUrl(request()->getHttpHost());
        $site = Site::where('hostname', $hostname)->first()->pluck('id');
        return $site[0];
    }
}
