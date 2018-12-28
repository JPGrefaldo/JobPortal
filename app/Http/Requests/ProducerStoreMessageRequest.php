<?php

namespace App\Http\Requests;

use App\Rules\ProducerMessage;
use Illuminate\Foundation\Http\FormRequest;

class ProducerStoreMessageRequest extends FormRequest
{
    protected $project;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $producer = auth()->user();
        $this->project = $this->route('project');

        if (! $producer->projects->contains($this->project->id)) {
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
            'message' => 'required|string',
            'recipients' => [
                'required',
                'array',
                'distinct',
                'exists:users,hash_id',
                new ProducerMessage($this->project),
            ]
        ];
    }
}
