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
            'resume'                       => 'nullable|file|mimes:pdf,doc,docx',
            'reel'                         => ['nullable', 'string', new Reel()],
            'socials'                      => 'array',
            'socials.*.id'                 => 'numeric',
            'socials.facebook.url'         => ['nullable', 'string', new Facebook()],
            'socials.twitter.url'          => ['nullable', 'string', new Twitter()],
            'socials.youtube.url'          => ['nullable', 'string', new YouTube()],
            'socials.google_plus.url'      => ['nullable', 'string', new GooglePlus(),],
            'socials.imdb.url'             => ['nullable', 'string', new IMDB(),],
            'socials.tumblr.url'           => ['nullable', 'string', new Tumblr(),],
            'socials.vimeo.url'            => ['nullable', 'string', new Vimeo(),],
            'socials.instagram.url'        => ['nullable', 'string', new Instagram(),],
            'socials.personal_website.url' => ['nullable', 'string', new TLDR(),],
        ];
    }

    /**
     * @return array
     *
     */
    public function attributes()
    {
        return [
            'bio'                          => 'biography',
            'socials.facebook.url'         => 'facebook',
            'socials.twitter.url'          => 'twitter',
            'socials.youtube.url'          => 'youtube',
            'socials.google_plus.url'      => 'google plus',
            'socials.imdb.url'             => 'imdb',
            'socials.tumblr.url'           => 'tumblr',
            'socials.vimeo.url'            => 'vimeo',
            'socials.instagram.url'        => 'instagram',
            'socials.personal_website.url' => 'personal website',
        ];
    }
}
