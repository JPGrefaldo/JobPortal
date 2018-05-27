<?php

namespace App\Http\Requests\Producer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'                  => 'required|string|min:3',
            'production_name'        => 'required|string|min:3',
            'production_name_public' => 'required|bool',
            'project_type_id'        => 'required|numeric|exists:project_types,id',
            'description'            => 'required|string|min:3',
            'location'               => 'nullable|string',
            'sites'                  => 'present|array',
            'sites.*'                => 'numeric|exists:sites,id'
        ];
    }
}
