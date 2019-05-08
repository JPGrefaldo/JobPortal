<?php

namespace App\Http\Requests\Producer;

use App\Models\ProjectJob;
use Illuminate\Foundation\Http\FormRequest;

class ProjectJobsSubmissionsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (ProjectJob::find($this->project_job_id) === null) {
            return false;
        }

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
            'project_job_id' => 'required|exists:project_jobs,id',
            'crew_id'        => 'required|exists:crews,id'
        ];
    }
}
