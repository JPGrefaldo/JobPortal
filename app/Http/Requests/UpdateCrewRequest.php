<?php

namespace App\Http\Requests;

class UpdateCrewRequest extends CreateCrewRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'photo' => 'nullable|image',
        ]);
    }
}
