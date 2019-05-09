<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\StoreCrewPosition;
use App\Actions\Crew\UpdateCrewPosition;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStoreCrewPositionRequest;
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

    public function fetchCrewPosition(Position $position)
    {
        $crew = auth()->user()->crew;

        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        return response()->json([
            'crewPosition' => $crewPosition,
            'gear'         => $crew->gears()->where('crew_position_id', $crewPosition->id)->first(),
            'reel'         => $crew->reels()->where('crew_position_id', $crewPosition->id)->first(),
        ]);
    }

    public function applyFor(Position $position, CreateStoreCrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validated();

        app(StoreCrewPosition::class)->execute($crew, $position, $data);
    }

    public function update(Position $position, CreateStoreCrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validated();

        app(UpdateCrewPosition::class)->execute($crew, $position, $data);
    }
}
