<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\StoreCrewPosition;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrewPositionRequest;
use App\Models\Position;

class CrewPositionController extends Controller
{
    public function applyFor(Position $position, StoreCrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validated();

        app(StoreCrewPosition::class)->execute($crew, $position, $data);
    }
}
