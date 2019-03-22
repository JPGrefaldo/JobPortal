<?php

namespace App\Http\Requests\Producer;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
            'title'                       => 'required|string|min:3',
            'production_name'             => 'required|string|min:3',
            'production_name_public'      => 'required|bool',
            'description'                 => 'required|string|min:3',
            'location'                    => 'nullable|string',
            'persons_needed'              => 'sometimes|required|numeric|min:1',
            'gear_provided'               => 'sometimes|nullable|string',
            'gear_needed'                 => 'sometimes|nullable|string',
            'sites'                       => 'present|array'
        ];
    }
}
