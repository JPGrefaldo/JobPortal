<?php

namespace App\Http\Requests;

use App\Rules\ExistInCrewDB;
use App\Rules\Reel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class StoreCrewPositionRequest extends FormRequest
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
            'bio'               => 'required|string|min:10',
            'resume'            => 'required|file|mimes:pdf,doc,docx',
            'reel_link'         => ['nullable', 'max:50', 'string', new Reel()],
            'reel_file'         => 'nullable|file|mimes:mp4,avi,wmv|max:20000',
            'gear'              => 'nullable|string|max:50|min:8',
            'union_description' => 'nullable|string|max:50|min:8'
        ];
        $rules = [
            'bio'               => 'required|nullable|string',
            'resume'            => [new ExistInCrewDB(), 'file','mimes:pdf,doc,docx'],
            'reel'              => ['max:50','string', new Reel(), new ExistInCrewDB() ],
            'gear'              => 'nullable|string|max:50|min:8',
            'union_description' => 'nullable|string|max:50|min:8'
        ];

        if ($this->hasFile('reel')){
            $rules['reel'] = ['file','mimes:mp4,avi,wmv','max:20000', new ExistInCrewDB()];
        }

        return $rules;
    }

    /**
     * @return array
     *
     */
    public function attributes()
    {
        return [
        ];
    }
}
