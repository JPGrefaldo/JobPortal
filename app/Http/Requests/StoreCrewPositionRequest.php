<?php

namespace App\Http\Requests;

use App\Rules\Reel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Position;

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
        if (Position::find($this->position_id)->has_gear) {
            $gear_rule = 'required|string|max:50|min:8';
        } else {
            $gear_rule = 'nullable|string|max:50|min:8';
        }

        return [
            'bio'               => 'required|string|min:10',
            'resume'            => 'required|file|mimes:pdf,doc,docx',
            'reel_link'         => ['nullable', 'max:50', 'string', new Reel()],
            'reel_file'         => 'nullable|file|mimes:mp4,avi,wmv|max:20000',
            'gear'              => $gear_rule,
            'union_description' => 'nullable|string|max:50|min:8',
        ];
    }
}
