<?php

namespace App\Models\Rules;

use App\Models\CrewPosition;
use App\Models\CrewResume;

class CrewResumeRules
{
    public static function resume($position, $resume)
    {
        $crewPosition = CrewPosition::byCrewAndPosition(auth()->user()->crew, $position)->first();
        
        if (isset($crewPosition)) {
            $crew_resume = CrewResume::where('crew_position_id', $crewPosition->id)->first();
        }

        if (isset($crew_resume)) {
            if ($resume !== "null") {
                return [
                    'nullable',
                    'mimes:pdf,doc,docx'
                ];
            } else {
                return 'nullable';
            }
        } else {
            return [
                'required',
                'mimes:pdf,doc,docx'
            ];
        }
    }
}