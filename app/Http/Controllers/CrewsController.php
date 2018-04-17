<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCrewRequest;
use App\Services\CrewsServices;
use Illuminate\Support\Facades\Auth;

class CrewsController extends Controller
{
    public function store(CreateCrewRequest $request)
    {
        $data = $request->validated();

        app(CrewsServices::class)->processCreate($data, Auth::user());

        return response('');
    }
}
