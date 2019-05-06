<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\ThreadResource;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pending-projects');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Project $project)
    {
        return response()->json([
            'message' => 'Project denied successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }

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

    public function unapprovedProjects()
    {
        $projects = Project::where('approved_at', null)->get();

        return response()->json(
            [
                'message'  => 'Succesfully fetched all projects.',
                'projects' => $projects,
            ],
            Response::HTTP_OK
        );
    }
}
