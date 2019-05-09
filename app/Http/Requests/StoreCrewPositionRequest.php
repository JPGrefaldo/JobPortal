<?php

namespace App\Http\Requests;

use App\Rules\Reel;
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
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'bio'               => 'required|string|min:10',
                    'resume'            => 'required|mimes:doc,pdf,docx,zip',
                    'reel_link'         => [
                        'nullable',
                        'max:50',
                        'string',
                        new Reel(),
                    ],
                    'reel_file'         => 'nullable|file|mimes:mp4,avi,wmv|max:20000',
                    'gear'              => 'nullable|string|max:50|min:8',
                    'union_description' => 'nullable|string|max:50|min:8',
                ];
            }
            case 'PUT':
            {
                return [
                    'bio'               => 'required|string|min:10',
                    'resume'            => 'nullable|mimes:doc,pdf,docx,zip',
                    'reel_link'         => [
                        'nullable',
                        'max:50',
                        'string',
                        new Reel(),
                    ],
                    'reel_file'         => 'nullable|file|mimes:mp4,avi,wmv|max:20000',
                    'gear'              => 'nullable|string|max:50|min:8',
                    'union_description' => 'nullable|string|max:50|min:8',
                ];
            }
            default: break;
        }
    }
}
