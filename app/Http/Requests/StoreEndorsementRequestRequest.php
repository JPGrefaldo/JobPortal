<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEndorsementRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $position = $this->route('position');
        return $position && $this->user()->crew->hasPosition($position);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'endorsers' => 'required|array',
            'endorsers.*.name' => 'required|string',
            'endorsers.*.email' => 'required|email',
        ];
    }
}
