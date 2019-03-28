<?php

namespace App\Http\Requests\Producer;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class CreateProjectJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $projectId = $this->get('project_id');

        if ($projectId === null) {
            return false;
        }

        $project = Project::find($projectId);

        if ($project === null) {
            return false;
        }

        return $this->user()->can('update', $project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'persons_needed'       => 'sometimes|required|numeric|min:1',
            'gear_provided'        => 'sometimes|nullable|string',
            'gear_needed'          => 'sometimes|nullable|string',
            'pay_rate'             => 'numeric',
            'pay_rate_type_id'     => 'numeric|exists:pay_types,id',
            'pay_type_id'          => 'required_if:pay_rate,0|numeric|exists:pay_types,id',
            'dates_needed'         => 'required|string',
            'notes'                => 'required|string|min:3',
            'position_id'          => 'required|numeric|exists:positions,id',
            'project_id'           => 'required',
        ];
    }
}
