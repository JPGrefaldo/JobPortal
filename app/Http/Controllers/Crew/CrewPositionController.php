<?php

namespace App\Http\Controllers\Crew;

use App\Models\Crew;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CrewPosition;
use App\Models\CrewGear;
use App\Models\CrewReel;
use App\Models\Position;

class CrewPositionController extends Controller
{
    public function applyFor(Position $position, Request $request)
    {
//        dump($request->toArray());
        $crew = auth()->user()->crew;

        $crew->positions()->attach($position, [
            'details'           => $request->bio,
            'union_description' => $request->union_description,
        ]);

        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first()->id;

        $crewGear = new CrewGear([
            'crew_id'          => $crew->id,
            'description'      => $request->gear,
            'crew_position_id' => $position->id
        ]);
        $crew->gears()->save($crewGear);

        $crewReel = new CrewReel([
            'crew_id'          => $crew->id,
            'url'              => $request->reel_link,
            'crew_position_id' => $position->id,
        ]);
        $crew->reels()->save($crewReel);

    }
}
