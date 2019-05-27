<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Crew;
use App\Models\User;
use App\Models\EndorsementEndorser;
use App\Rules\CreateCrewEndorsement;

class StoreCrewEndorsementRequest extends FormRequest
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
            'email'   => [
                'required',
                'email',
                new CreateCrewEndorsement,
            ],
            'message' => 'required',
        ];
    }
}
