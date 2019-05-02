<?php

namespace App\Http\Requests\Producer;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ProjectJob;
use App\Models\Submission;

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
            'project_job_id' => 'exists:project_jobs,id',
            'crew_id'        => 'required:crews,id'
        ];
    }
}
