<?php

namespace App\Http\Requests\Producer;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ProjectJob;
use App\Models\Submission;
use Illuminate\Http\Response;

class ProjectJobsSubmissionsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(ProjectJob::find($this->project_job_id) === null) {
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
            'project_job_id' => 'required|numeric',
            'crew_id'        => 'required|numeric'
        ];
    }

    public function createSubmission()
    {
        $data = Submission::create([
            'project_job_id' => $this->project_job_id,
            'crew_id'        => $this->crew_id
        ]);
    }
}
