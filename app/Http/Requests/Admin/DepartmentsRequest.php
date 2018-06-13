<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentsRequest extends FormRequest
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
            'name'        => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments')->ignore($this->getDepartmentId()),
            ],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * @return int|null
     */
    protected function getDepartmentId()
    {
        return ($this->department === null)
            ? null
            : $this->department->id;
    }
}