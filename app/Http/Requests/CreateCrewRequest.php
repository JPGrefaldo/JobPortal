<?php

namespace App\Http\Requests;

use App\Rules\YouTube;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateCrewRequest extends FormRequest
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
     * Add replacer to change the message on the Youtube rule
     *
     * @param  \Illuminate\Contracts\Validation\Factory  $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createDefaultValidator(Factory $factory)
    {
        $validator = parent::createDefaultValidator($factory);
        $validator->addReplacer(YouTube::class, function() {
            return 'Youtube must be a valid YouTube URL.';
        });

        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bio'    => 'nullable|string',
            'photo'  => 'required|image',
            'resume' => 'sometimes|file|mimes:pdf,doc,docx',
            'socials' => 'required|array',
            'socials.youtube.value' => ['string', new YouTube()]
        ];
    }
}
