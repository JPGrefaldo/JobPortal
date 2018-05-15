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
            'project_type_id'             => 'required|numeric|exists:project_types,id',
            'description'                 => 'required|string|min:3',
            'location'                    => 'nullable|string',
            'jobs'                        => 'present|array',
            'jobs.*.persons_needed'       => 'sometimes|required|numeric',
            'jobs.*.gear_provided'        => 'sometimes|nullable|string',
            'jobs.*.gear_needed'          => 'sometimes|nullable|string',
            'jobs.*.pay_rate'             => 'numeric',
            'jobs.*.pay_rate_type_id'     => 'numeric|exists:pay_types,id',
            'jobs.*.pay_type_id'          => 'sometimes|numeric|exists:pay_types,id',
            'jobs.*.dates_needed'         => 'required|string',
            'jobs.*.notes'                => 'required|string|min:3',
            'jobs.*.travel_expenses_paid' => 'required|bool',
            'jobs.*.rush_call'            => 'required|bool',
            'jobs.*.position_id'          => 'required|numeric|exists:positions,id',
        ];
    }
}
