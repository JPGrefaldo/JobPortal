<?php

namespace App\Http\Requests;

use App\Models\Position;
use App\Models\Rules\CrewGearRules;
use App\Models\Rules\CrewPositionRules;
use App\Models\Rules\CrewReelRules;
use App\Models\Rules\CrewResumeRules;
use Illuminate\Foundation\Http\FormRequest;

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
        if (is_string($this->position)) {
            $position = Position::find($this->position);
        } else {
            $position = $this->position;
        }

        return [
            'bio'               => 'required|string|min:10',
            'resume'            => CrewResumeRules::resume($position, $this->resume),
            'reel_link'         => CrewReelRules::reel_link($position),
            'reel_file'         => 'nullable|file|mimes:mp4,avi,wmv|max:20000',
            'union_description' => CrewPositionRules::position_description($position),
            'gear'              => CrewGearRules::gear($position),
            'gear_photos'       => CrewGearRules::gear_photos($this->gear_photos),
        ];
    }
}
