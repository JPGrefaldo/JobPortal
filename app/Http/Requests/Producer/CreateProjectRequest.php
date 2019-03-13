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
            'paid_travel'                 => 'required|bool',
            'project_job'                 => 'present|array',
            'project_job.*.pay_rate'      => 'numeric',
            'project_job.*.pay_type_id'   => 'required_if:jobs.*.pay_rate,0|numeric',
            'project_job.*.position_id'   => 'required|numeric',
            'project_job.*.dates_needed'  => 'required|string',
            'project_job.*.notes'         => 'required|string|min:3',
            'sites'                       => 'present|array',
        ];
    }
}
