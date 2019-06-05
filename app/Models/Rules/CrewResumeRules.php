<?php

namespace App\Models\Rules;

class CrewResumeRules
{
    public static function resume($position)
    {
        dd($position);

        $crewPosition = CrewPosition::byCrewAndPosition(auth()->user()->crew, $position)->first();

        $crew_resume = CrewResume::where('crew_position_id', $crewPosition->id)->first();

        if (isset($crew_resume)) {
            return [
                'nullable',
                'file',
                'mimes:pdf,doc,docx'
            ];
        } else {
            return [
                'required',
                'file',
                'mimes:pdf,doc,docx'
            ];
        }
    }
}