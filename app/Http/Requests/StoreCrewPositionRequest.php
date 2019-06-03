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
        $position = Position::find($this->position_id);
        $crewPosition = CrewPosition::where('crew_id', auth()->user()->crew->id)->where('position_id', $this->position)->first();

        if (isset($crewPosition)) {
            $crew_resume = CrewResume::where('crew_position_id', $crewPosition->id)->first();
            $crew_reel   = CrewReel::where('crew_position_id', $crewPosition->id)->first();
        }

        if (isset($crew_resume)) {
            if ($this->resume != "null") {
                $resume_rule = 'file|mimes:pdf,doc,docx';
            } else {
                $resume_rule = 'nullable';
            }
        } else {
            $resume_rule = 'required|file|mimes:pdf,doc,docx';
        }

        if (isset($crew_reel)) {
            $reel_link_rule = ['nullable', 'max:50', 'string', new Reel()];
        } else {
            $reel_link_rule = ['required', 'max:50', 'string', new Reel()];
        }

        if ($this->gear_photos != "null") {
            $gear_photos_rule = 'nullable|image|mimes:jpeg,png';
        } else {
            $gear_photos_rule = 'nullable';
        }

        if ($position['has_union']) {
            $union_rule = 'required|string|max:50|min:8';
        } else {
            $union_rule = 'nullable|string|max:50|min:8';
        }
        
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
