<?php

namespace Tests\Feature;

use App\Models\Crew;
use App\Models\Role;
use App\Rules\YouTube;
use App\Services\AuthServices;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrewsFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function create()
    {
        Storage::fake();

        $user = factory(User::class)->create();
        app(AuthServices::class)->createByRoleName(
            Role::CREW,
            $user,
            $this->getCurrentSite()
        );

        $data = [
            'bio'     => 'some bio',
            'photo'   => UploadedFile::fake()->image('photo.png'),
            'resume'  => UploadedFile::fake()->create('resume.pdf'),
            'socials' => [
                'facebook' => [

                ],
            ],
        ];

        $response = $this->actingAs($user)->post('crews/create', $data);

        $response->assertSuccessful();

        $crew = Crew::where('user_id', $user->id)->first();

        $this->assertEquals($data['bio'], $crew->bio);

        $resume = $crew->resumes->first();

        Storage::assertExists($crew->photo);
        Storage::assertExists($crew->resumes->first()->url);
    }

    /** @test */
    public function invalid_data()
    {
        Storage::fake();

        $user = factory(User::class)->create();
        app(AuthServices::class)->createByRoleName(
            Role::CREW,
            $user,
            $this->getCurrentSite()
        );

        $data = [
            'bio'     => '',
            'photo'   => UploadedFile::fake()->image('photo.png'),
            'resume'  => UploadedFile::fake()->create('resume.pdf'),
            'socials' => [
                'facebook'         => [
                    'url' => 'https://invalid-facebook.com/invalid',
                ],
                'twitter'          => [
                    'url' => 'https://invalid-twitter.com/invalid',
                ],
                'youtube'          => [
                    'url' => 'https://invalid-youtube.com/invalid',
                ],
                'google_plus'      => [
                    'url' => 'https://invalid-gplus.com/invalid',
                ],
                'imdb'             => [
                    'url' => 'https://invalid-imdb.com/invalid',
                ],
                'tumblr'           => [
                    'url' => 'https://invalid-tumblr.test/invalid',
                ],
                'vimeo'            => [
                    'url' => 'https://invalid-vimeo.com/invalid',
                ],
                'instagram'        => [
                    'url' => 'https://invalid-instagram.com/invalid',
                ],
                'personal_website' => [
                    'url' => 'http://mysite.test',
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('crews/create', $data);

        $response->assertSessionHasErrors(
            [
                'socials.facebook.url'         => 'facebook must be a valid Facebook URL.',
                'socials.twitter.url'          => 'twitter must be a valid Twitter URL.',
                'socials.youtube.url'          => 'youtube must be a valid YouTube URL.',
                'socials.google_plus.url'      => 'google plus must be a valid Google Plus URL.',
                'socials.imdb.url'             => 'imdb must be a valid IMDB URL.',
                'socials.tumblr.url'           => 'tumblr must be a valid Tumblr URL.',
                'socials.vimeo.url'            => 'vimeo must be a valid Vimeo URL.',
                'socials.instagram.url'        => 'instagram must be a valid Instagram URL.',
                'socials.personal_website.url' => 'The personal website is invalid.',
            ]
        );
    }
}
