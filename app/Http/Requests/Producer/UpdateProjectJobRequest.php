<?php

namespace App\Http\Requests\Producer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->job);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'persons_needed'       => 'sometimes|required|numeric|min:1',
            'gear_provided'        => 'sometimes|nullable|string',
            'gear_needed'          => 'sometimes|nullable|string',
            'pay_rate'             => 'numeric',
            'pay_rate_type_id'     => 'numeric|exists:pay_types,id',
            'pay_type_id'          => 'required_if:pay_rate,0|numeric|exists:pay_types,id',
            'dates_needed'         => 'required|string',
            'notes'                => 'required|string|min:3',
            'travel_expenses_paid' => 'required|bool',
            'rush_call'            => 'required|bool',
        ];
    }
}
