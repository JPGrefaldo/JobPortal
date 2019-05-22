<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\DeleteCrewPositionGear;
use App\Http\Controllers\Controller;
use App\Models\Position;

class CrewPositionGearController extends Controller
{
    /**
     * @param \App\Models\CrewPosition
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Position $position)
    {
        $crew = auth()->user()->crew;

        return app(DeleteCrewPositionGear::class)->execute($crew, $position);
    }
}
