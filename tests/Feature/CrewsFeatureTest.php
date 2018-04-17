<?php

namespace Tests\Feature;

use App\Models\Crew;
use App\Models\Role;
use App\Rules\YouTube;
use App\Services\AuthServices;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\Data\SocialLinkTypeID;
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
                'facebook'         => [
                    'url' => 'https://www.facebook.com/castingcallsamerica/',
                    'id'  => SocialLinkTypeID::FACEBOOK,
                ],
                'twitter'          => [
                    'url' => 'https://twitter.com/casting_america',
                    'id'  => SocialLinkTypeID::TWITTER,
                ],
                'youtube'          => [
                    'url' => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJw',
                    'id'  => SocialLinkTypeID::YOUTUBE,
                ],
                'google_plus'      => [
                    'url' => 'https://plus.google.com/+marvel',
                    'id'  => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                'imdb'             => [
                    'url' => 'http://www.imdb.com/name/nm0000134/',
                    'id'  => SocialLinkTypeID::IMDB,
                ],
                'tumblr'           => [
                    'url' => 'http://test.tumblr.com',
                    'id'  => SocialLinkTypeID::TUMBLR,
                ],
                'vimeo'            => [
                    'url' => 'https://vimeo.com/mackevision',
                    'id'  => SocialLinkTypeID::VIMEO,
                ],
                'instagram'        => [
                    'url' => 'https://www.instagram.com/castingamerica/',
                    'id'  => SocialLinkTypeID::INSTAGRAM,
                ],
                'personal_website' => [
                    'url' => 'https://castingcallsamerica.com',
                    'id'  => SocialLinkTypeID::PERSONAL_WEBSITE,
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

        // assert that the socials has been created
        $crew->load('social.socialLinkType');

        $this->assertCount(9, $crew->social);

        foreach (array_keys($data['socials']) as $idx => $key) {
            // check if the crew social data is correct
            $crewSocial = $crew->social->get($idx);

            $this->assertEquals(
                [
                    $data['socials'][$key]['id'],
                    $data['socials'][$key]['url'],
                ],
                [
                    $crewSocial->social_link_type_id,
                    $crewSocial->url,
                ]
            );

            // check if the social link type is correct
            $this->assertEquals(
                str_replace('_', ' ', $key),
                strtolower($crewSocial->socialLinkType->name)
            );
        }
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
