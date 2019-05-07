<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\StoreCrewPosition;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrewPositionRequest;
use App\Models\Position;
use App\Models\CrewPosition;
use App\Actions\Crew\UpdateCrewPosition;

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

    public function applyFor(Position $position, StoreCrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validated();

        app(StoreCrewPosition::class)->execute($crew, $position, $data);
    }

    public function update(Position $position, StoreCrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        // $exploded = explode(',', $request->resume);
        // $decoded = base64_decode($exploded[1]);
        // $extension = $exploded[0];
        // $fileName = str_random() . '.' . $extension;
        // $path = public_path() . '/' / $fileName;
        // file_put_contents($path, $decoded);

        // $request['resume'] = $fileName;

        \Log::info($request->all());

        $data = $request->validated();

        app(UpdateCrewPosition::class)->execute($crew, $position, $data);
    }
}
