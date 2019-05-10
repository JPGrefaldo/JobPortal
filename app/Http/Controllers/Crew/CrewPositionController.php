<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\StoreCrewPosition;
use App\Actions\Crew\UpdateCrewPosition;
use App\Http\Controllers\Controller;
use App\Http\Requests\CrewPositionRequest;
use App\Models\Position;
use App\Models\CrewPosition;

class CrewPositionController extends Controller
{
    public function checkCrewPositions()
    {
        return response()->json(
            (auth()->user()->crew->positions->pluck('id'))
        );
    }

    public function fetchCrewPosition()
    {
        $crew = auth()->user()->crew;

        $crewPositions = $crew->crewPositions;

        return response()->json([
            'crewPositions' => $crewPositions,
            'gears' => $crew->gears->where('crew_id', $crew->id),
            'reels' => $crew->reels->where('crew_id', $crew->id),
        ]);
    }

    public function applyFor(Position $position, CrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validated();

        app(StoreCrewPosition::class)->execute($crew, $position, $data);
    }

    public function update(Position $position, CrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validated();

        app(UpdateCrewPosition::class)->execute($crew, $position, $data);
    }
}
