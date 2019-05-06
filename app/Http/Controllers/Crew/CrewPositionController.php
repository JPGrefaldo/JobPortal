<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\StoreCrewPosition;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrewPositionRequest;
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

    public function fetchCrewPosition($id)
    {
        return response()->json(
            CrewPosition::where('position_id', $id)->get()
        );
    }

    public function applyFor(Position $position, StoreCrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validated();

        app(StoreCrewPosition::class)->execute($crew, $position, $data);
    }
}
