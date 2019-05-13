<?php

namespace App\Http\Controllers\API\Producer;

use App\Actions\Producer\Project\CreateProject;
use App\Actions\Producer\Project\CreateRemoteProject;
use App\Actions\Producer\Project\UpdateProject;
use App\Actions\Producer\Project\UpdateRemoteProject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\CreateProjectRequest;
use App\Models\Project;
use App\Models\Site;
use App\Utils\UrlUtils;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return response()->json(
            [
                'message'   => 'Succesfully fetched all projects.',
                'projects'  => $projects->load([
                    'remotes', 
                    'jobs'  => function($query) {
                        $query->with('position', 'pay_type');
                    },
                ]),
            ],
            Response::HTTP_OK
        );
    }

    public function store(CreateProjectRequest $request)
    {
        $user = auth()->user()->id;
        $site_id = $this->getHostSiteID();

        $project = app(CreateProject::class)->execute($user, $site_id, $request);

        if (! isset($project->id)) {
            return response()->json(
                [
                    'message', 'Unable to save the project. Please try again.',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        app(CreateRemoteProject::class)->execute($project, $request->remotes);

        return response()->json(
            [
                'message' => 'Project successfully added.',
                'project' => $project->load('remotes'),
            ],
            Response::HTTP_CREATED
        );
    }

    public function update(Project $project, CreateProjectRequest $request)
    {
        $project = app(UpdateProject::class)->execute($project, $request);

        if ($project->id) {
            app(UpdateRemoteProject::class)->execute($project, $request->remotes);

            return response()->json(
                [
                    'message' => 'Project successfully updated.',
                    'project' => $project->load('remotes'),
                ],
                Response::HTTP_OK
            );
        }

        return response()->json(
            [
                'message', 'Unable to update the project. Please try again.',
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    public function show(Project $project)
    {
        return response()->json(
            [
                'project' => $project->load(['jobs', 'remotes']),
            ],
            Response::HTTP_OK
        );
    }

    public function pending(Request $request)
    {
        if ($request->query('count')) {
            return response()->json(
                [
                    'message'   => 'Succesfully fetched all pending projects count.',
                    'count'     => Project::getPending()->count(),
                ],
                Response::HTTP_OK
            );
        }

        return response()->json(
            [
                'message'   => 'Succesfully fetched all pending projects.',
                'projects'  => Project::getPending()->load(
                    [
                        'remotes',
                        'jobs' => function($query) {
                            $query->with('position', 'pay_type');
                        } 
                    ]
                ),
            ],
            Response::HTTP_OK
        );
    }

    public function approved(Request $request)
    {
        if ($request->query('count')) {
            return response()->json(
                [
                    'message'   => 'Succesfully fetched all approved projects count.',
                    'count' => Project::getApproved()->count(),
                ],
                Response::HTTP_OK
            );
        }

        return response()->json(
            [
                'message'   => 'Succesfully fetched all approved projects.',
                'projects'  => Project::getApproved()->load(
                    [
                        'remotes',
                        'jobs' => function($query) {
                            $query->with('position', 'pay_type');
                        } 
                    ]
                ),
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
