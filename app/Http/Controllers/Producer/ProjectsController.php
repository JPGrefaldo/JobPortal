<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\CreateProjectRequest;
use App\Services\ProjectsServices;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    public function store(CreateProjectRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();

        app(ProjectsServices::class)->create(array_only($data, [
            'title',
            'production_name',
            'production_name_public',
            'project_type_id',
            'description',
            'location',
            'user_id'
        ]));
    }
}
