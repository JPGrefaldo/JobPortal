<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class ProducerStoreMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $producer = auth()->user();
        $project = $this->route('project');
        if (! $producer->whereHas('roles', function ($query) {
            $query->where('name', Role::PRODUCER);
        })->get()) {
            return false;
        }

        if (! $producer->projects->contains($project->id)) {
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
            'subject' => 'required|string',
            'message' => 'required|string',
            'recipients' => 'required|array',
            'recipients' => 'exists:users,hash_id',
        ];
    }
}
