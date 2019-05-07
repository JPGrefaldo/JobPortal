<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\GetCrewPositionByPosition;
use App\Actions\Crew\StoreCrewPosition;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrewPositionRequest;
use App\Models\Position;
use App\Models\CrewPosition;

class CrewPositionController extends Controller
{
    public function applyFor(Position $position, StoreCrewPositionRequest $request)
    {
        $crew = auth()->user()->crew;

        $data = $request->validated();

        app(StoreCrewPosition::class)->execute($crew, $position, $data);

        return 'success';
    }

    public function getPositionData(Position $position)
    {
        return app(GetCrewPositionByPosition::class)->execute(auth()->user(), $position)->load(['resume','gear']);        
    }

    public function removeResume(CrewPosition $position)
    {
        return $position->resume->delete() ? 'success' : 'failed';
    }
}
