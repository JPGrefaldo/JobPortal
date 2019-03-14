<?php

namespace App\Http\Controllers;

use App\Actions\Crew\StoreCrew;
use App\Actions\Crew\UpdateCrew;
use App\Http\Requests\CreateCrewRequest;
use App\Http\Requests\UpdateCrewRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Crew;

class CrewsController extends Controller
{
    public function store(CreateCrewRequest $request)
    {
        $data = $request->validated();

        app(StoreCrew::class)->execute(auth()->user(), $data);

        return response('');
    }

    public function update(UpdateCrewRequest $request, Crew $crew)
    {
        $data = $request->validated();

        app(UpdateCrew::class)->execute($crew, $data);

        return response('');
    }
}
