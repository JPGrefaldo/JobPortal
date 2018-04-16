<?php

namespace App\Http\Requests;

use App\Rules\YouTube;
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
            'bio'                   => 'nullable|string',
            'photo'                 => 'required|image',
            'resume'                => 'sometimes|file|mimes:pdf,doc,docx',
            'socials'               => 'required|array',
            'socials.youtube.value' => ['string', new YouTube()],
        ];
    }

    /**
     * @return array
     *
     */
    public function attributes()
    {
        return [
            'socials.youtube.value' => 'youtube'
        ];
    }
}
