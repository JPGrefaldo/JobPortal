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
            // 'socials.*.id'                 => 'numeric',
            // 'socials.Facebook'         => ['nullable', 'string', new Facebook()],
            // 'socials.Twitter'          => ['nullable', 'string', new Twitter()],
            // 'socials.Youtube'          => ['nullable', 'string', new YouTube()],
            // 'socials.Google Plus'      => ['nullable', 'string', new GooglePlus(),],
            // 'socials.Imdb'             => ['nullable', 'string', new IMDB(),],
            // 'socials.Tumblr'           => ['nullable', 'string', new Tumblr(),],
            // 'socials.Vimeo'            => ['nullable', 'string', new Vimeo(),],
            // 'socials.Instagram'        => ['nullable', 'string', new Instagram(),],
            // 'socials.Personal Website' => ['nullable', 'string', new TLDR(),],
        ];
    }

    /**
     * @return array
     *
     */
    public function attributes()
    {
        return [
            // 'bio'                          => 'biography',
            // 'socials.facebook.url'         => 'facebook',
            // 'socials.twitter.url'          => 'twitter',
            // 'socials.youtube.url'          => 'youtube',
            // 'socials.google_plus.url'      => 'google plus',
            // 'socials.imdb.url'             => 'imdb',
            // 'socials.tumblr.url'           => 'tumblr',
            // 'socials.vimeo.url'            => 'vimeo',
            // 'socials.instagram.url'        => 'instagram',
            // 'socials.personal_website.url' => 'personal website',
        ];
    }
}
