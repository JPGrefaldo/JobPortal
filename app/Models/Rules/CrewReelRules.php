<?php

namespace App\Models\Rules;

use App\Models\CrewPosition;
use App\Models\CrewReel;
use App\Rules\Reel;

class CrewReelRules
{
    public static function reel_link($position)
    {
        $crewPosition = CrewPosition::byCrewAndPosition(auth()->user()->crew, $position)->first();

        if (isset($crewPosition)) {
            $crew_reel = CrewReel::where('crew_position_id', $crewPosition->id)->first();
        }

        if (isset($crew_reel)) {
            return [
                'nullable', 
                'max:50', 
                'string', 
                new Reel()];
        } else {
            return [
                'required', 
                'max:50', 
                'string', 
                new Reel()];
        }
    }
}