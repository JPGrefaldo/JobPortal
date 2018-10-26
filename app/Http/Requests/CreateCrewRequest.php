<?php

namespace App\Http\Requests;

use App\Rules\Reel;
use Illuminate\Foundation\Http\FormRequest;

class CreateCrewRequest extends FormRequest
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
        return [
            'bio'                          => 'required|nullable|string',
            'photo'                        => 'image',
            'resume'                  => 'nullable|file|mimes:pdf,doc,docx',
            'reel'                    => ['nullable', 'string', new Reel()],
            'reel_file'                    => 'nullable|file|mimes:mp4,avi,wmv | max:20000',
            'socials'                      => 'array',
        ];
    }

    /**
     * @return array
     *
     */
    public function attributes()
    {
        return [
        ];
    }
}
