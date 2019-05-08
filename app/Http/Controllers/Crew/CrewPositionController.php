<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\StoreCrewPosition;
use App\Actions\Crew\GetCrewPositionByPosition;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrewPositionRequest;
use App\Models\Position;
use App\Rules\Reel;
use App\Http\Requests\StoreCrewPositionRequest;

class CrewPositionController extends Controller
{
    public function applyFor(Position $position, StoreCrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validated();

        app(StoreCrewPosition::class)->execute($crew, $position, $data);
    }

    public function fetchPosition(Position $position)
    {
        return app(GetCrewPositionByPosition::class)->execute(auth()->user(), $position)->load(['reel','gear','resume']);
    }
}
