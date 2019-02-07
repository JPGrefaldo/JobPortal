<?php

namespace App\Http\Controllers\Crew;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CrewPosition;
use App\Models\CrewGear;
use App\Models\Position;

class CrewPositionController extends Controller
{
    public function applyFor(Position $position, Request $request)
    {
        $crew = new CrewPosition();

        $crew->position->attach($position, [
            'details' => $request->details,
            'union_description' => $request->description,
        ]);

        $crewPosition = $crew->position->where([
            'details' => $request->details,
            'union_description' => $request->description,
        ])->first()->pivot;

        CrewGear::create([
            'crew_id' => $crew->id,
            'description' => $request->gear,
            'crew_position_id' => $crewPosition->id,
        ]);

        CrewReel::create([
            'crew_id' => $crew->id,
            'url' => $request->reel,
            'crew_position_id' => $crewPosition->id,
        ]);
    }
}
