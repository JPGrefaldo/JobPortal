<?php

namespace App\Http\Requests;

use App\Rules\Facebook;
use App\Rules\GooglePlus;
use App\Rules\IMDB;
use App\Rules\Instagram;
use App\Rules\Reel;
use App\Rules\TLDR;
use App\Rules\Tumblr;
use App\Rules\Twitter;
use App\Rules\Vimeo;
use App\Rules\YouTube;
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bio'                          => 'required|nullable|string',
            'photo'                        => 'image',
            'resume_file'                  => 'nullable|file|mimes:pdf,doc,docx',
            'reel_link'                    => ['nullable', 'string', new Reel()],
            'reel_file'                    => 'nullable|file|mimes:mp4,avi,wmv | max:20000',
            'socials'                      => 'array',
        ];
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
