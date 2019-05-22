<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\DeleteCrewPositionResume;
use App\Http\Controllers\Controller;
use App\Models\Position;

class CrewPositionResumeController extends Controller
{
    /**
     * @param \App\Models\CrewPosition
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Position $position)
    {
        $crew = auth()->user()->crew;

        return app(DeleteCrewPositionResume::class)->execute($crew, $position);
    }
}