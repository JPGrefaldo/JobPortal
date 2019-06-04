<?php

namespace App\Http\Requests;

use App\Models\Position;
use App\Rules\Reel;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\CrewPosition;
use App\Models\CrewResume;
use App\Models\CrewReel;

class StoreCrewPositionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $position     = $this->position;
        $crewPosition = CrewPosition::byCrewAndPosition(auth()->user()->crew, $position)->first();

        if (isset($crewPosition)) {
            $crew_resume = CrewResume::where('crew_position_id', $crewPosition->id)->first();
            $crew_reel   = CrewReel::where('crew_position_id', $crewPosition->id)->first();
        }

        // Since nullable file upload rules are not working, These conditions are added for resume, gear_photos, reel_link to work
        // example: when resume is equals to 'null', the resume will be nullable

        // resume is required if it doesn't exist on crew_resumes table
        if (isset($crew_resume)) {
            // If there's no resume upload validation rule will be null
            if ($this->resume != "null") {
                $resume_rule = 'file|mimes:pdf,doc,docx';
            } else {
                $resume_rule = 'nullable';
            }
        } else {
            $resume_rule = 'required|file|mimes:pdf,doc,docx';
        }

        // If there's no gear_photos upload validation rule will be null
        if ($this->gear_photos != "null") {
            $gear_photos_rule = 'nullable|image|mimes:jpeg,png';
        } else {
            $gear_photos_rule = 'nullable';
        }

        // reel_link is required if it doesn't exist on crew_reels table
        if (isset($crew_reel)) {
            $reel_link_rule = ['nullable', 'max:50', 'string', new Reel()];
        } else {
            $reel_link_rule = ['required', 'max:50', 'string', new Reel()];
        }

        // Union is required if position has union
        if ($position['has_union']) {
            $union_rule = 'required|string|max:50|min:8';
        } else {
            $union_rule = 'nullable|string|max:50|min:8';
        }
        
        // Gear is required if position has gear
        if ($position['has_gear']) {
            $gear_rule = 'required|string|max:50|min:8';
        } else {
            $gear_rule = 'nullable|string|max:50|min:8';
        }

        return [
            'bio'               => 'required|string|min:10',
            'resume'            => $resume_rule,
            'reel_link'         => $reel_link_rule,
            'reel_file'         => 'nullable|file|mimes:mp4,avi,wmv|max:20000',
            'union_description' => $union_rule,
            'gear'              => $gear_rule,
            'gear_photos'       => $gear_photos_rule,
        ];
    }
}
