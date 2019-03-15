<?php

namespace App\Http\Controllers\API\Producer;

use App\Actions\Producer\Project\CreateProject;
use App\Actions\Producer\Project\CreateProjectJob;
use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\CreateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\ProjectType;
use App\Models\RemoteProject;
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

    public function projectType()
    {
        $types = ProjectType::all();

        return response()->json([
            'projectType' => $types
        ]);
    }

    public function store(CreateProjectRequest $request)
    {   
        $user = auth()->user()->id;
        $site_id = $this->getHostSiteID();

        $project = app(CreateProject::class)->execute($user, $site_id, $request);

        if (isset($project->id) && count($request->jobs) > 0){
            
            foreach($request->jobs as $job){
                app(CreateProjectJob::class)->execute($job, $project);

                $site_ids = $this->getSiteIDs($job);

                foreach ($site_ids as $site_id){
                    $this->storeRemoteProjects($project->id, $site_id);
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

    private function getSiteIDs($job)
    {
        $site_ids = $job['sites'];

        if (count($site_ids) === 1 && $site_ids[0] === 'all'){
            $site_ids = Site::all()->pluck('id');
        }

        return $site_ids;
    }

    private function storeRemoteProjects($project_id, $site_id)
    {
        RemoteProject::create([
            'project_id' => $project_id,
            'site_id' => $site_id
        ]);
    }
    
}
