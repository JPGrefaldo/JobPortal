<?php

namespace App\Http\Requests;

use App\Models\Position;
use App\Rules\Reel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
            'resume'            => 'required|file|mimes:pdf,doc,docx',
            'reel_link'         => ['nullable', 'max:50', 'string', new Reel()],
            'reel_file'         => 'nullable|file|mimes:mp4,avi,wmv|max:20000',
            'gear'              => 'nullable|string|max:50|min:8',
            'union_description' => $union_rule,
            'gear'              => $gear_rule,
            'gear_photos'       => 'nullable|image|mimes:jpeg,png',
            'union_description' => 'nullable|string|max:50|min:8',
        ];
    }
}
