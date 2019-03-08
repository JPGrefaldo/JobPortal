<?php

namespace App\Http\Requests;

class UpdateCrewRequest extends CreateCrewRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->id === $this->route('crew')->user->id;
    }
}
