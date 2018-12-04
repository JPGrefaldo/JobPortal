<?php

namespace App\Http\Requests\Producer\Message;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $project = $this->route('project');

        if ($project->trashed()) {
            return false;
        }

        $message = $this->route('message');
        $thread = $message->thread;
        $producerUser = auth()->user();

        if (! $producerUser->hash_id === $thread->creator()->hash_id) {
            return false;
        }

        $crew = $message->user->crew;
        if (! $project->contributors->contains($crew->id)) {
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
            //
        ];
    }
}
