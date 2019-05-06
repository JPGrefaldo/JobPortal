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
            'photo'                        => 'nullable|image',
            'resume'                       => 'nullable|file|mimes:pdf,doc,docx',
            'reel_link'                    => ['nullable', 'string', new Reel()],
            'reel_file'                    => 'nullable|file|mimes:mp4,avi,wmv | max:20000',
            'socials'                      => 'array',
            'socials.facebook.url'         => ['nullable', new Facebook],
            'socials.twitter.url'          => ['nullable', new Twitter],
            'socials.youtube.url'          => ['nullable', new YouTube],
            'socials.google_plus.url'      => ['nullable', new GooglePlus],
            'socials.imdb.url'             => ['nullable', new IMDB],
            'socials.tumblr.url'           => ['nullable', new Tumblr],
            'socials.vimeo.url'            => ['nullable', new Vimeo],
            'socials.instagram.url'        => ['nullable', new Instagram],
            'socials.personal_website.url' => ['nullable', new TLDR],
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
