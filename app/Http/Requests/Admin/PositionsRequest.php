<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PositionsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name'             => ['required', 'string', 'max:255'],
            'department_id'    => ['required', 'numeric', 'exists:departments,id'],
            'position_type_id' => ['required', 'numeric', 'exists:position_types,id'],
            'has_gear'         => ['bool'],
            'has_union'        => ['bool'],
        ];
    }
}
