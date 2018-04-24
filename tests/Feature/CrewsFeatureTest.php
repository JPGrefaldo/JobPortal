<?php

namespace Tests\Feature;

use App\Models\Crew;
use App\Models\Role;
use App\Services\AuthServices;
use App\Models\User;
use App\Services\CrewsServices;
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

        $user = $this->getCrewUser();
        $data = $this->getCreateData();

        $response = $this->actingAs($user)->post('/crews', $data);

        $response->assertSuccessful();

        // assert crew data
        $crew = Crew::where('user_id', $user->id)->first();

        $this->assertEquals($data['bio'], $crew->bio);
        Storage::assertExists($crew->photo);
        // assert general resume
        $resume = $crew->resumes->first();

        $this->assertEquals(1, $resume->general);
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

        // assert general reel has been created
        $reel = $crew->reels->where('general', 1)->first();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://www.youtube.com/embed/G8S81CEBdNs',
                'general' => 1,
            ],
            $reel->toArray()
        );
    }

    /** @test */
    public function create_not_required()
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
            'resume'  => '',
            'reel'    => '',
            'socials' => [
                'facebook'         => [
                    'url' => '',
                    'id'  => SocialLinkTypeID::FACEBOOK,
                ],
                'twitter'          => [
                    'url' => '',
                    'id'  => SocialLinkTypeID::TWITTER,
                ],
                'youtube'          => [
                    'url' => '',
                    'id'  => SocialLinkTypeID::YOUTUBE,
                ],
                'google_plus'      => [
                    'url' => '',
                    'id'  => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                'imdb'             => [
                    'url' => '',
                    'id'  => SocialLinkTypeID::IMDB,
                ],
                'tumblr'           => [
                    'url' => '',
                    'id'  => SocialLinkTypeID::TUMBLR,
                ],
                'vimeo'            => [
                    'url' => '',
                    'id'  => SocialLinkTypeID::VIMEO,
                ],
                'instagram'        => [
                    'url' => '',
                    'id'  => SocialLinkTypeID::INSTAGRAM,
                ],
                'personal_website' => [
                    'url' => '',
                    'id'  => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('/crews', $data);

        $response->assertSuccessful();

        // assert crew data
        $crew = Crew::where('user_id', $user->id)->first();

        $this->assertEquals('', $crew->bio);

        // assert photo
        Storage::assertExists($crew->photo);

        // assert that there are no resumes
        $this->assertCount(0, $crew->resumes);

        // assert that no socials has been created
        $this->assertCount(0, $crew->social);

        // assert that no reels has been created
        $this->assertCount(0, $crew->reels);
    }

    /** @test */
    public function create_invalid_data()
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
            'reel'    => 'https://some-invalid-reel.com',
            'socials' => [
                'facebook'         => [
                    'url' => 'https://invalid-facebook.com/invalid',
                ],
                'twitter'          => [
                    'url' => 'https://invalid-twitter.com/invalid',
                    'id'  => SocialLinkTypeID::TWITTER,
                ],
                'youtube'          => [
                    'url' => 'https://invalid-youtube.com/invalid',
                    'id'  => SocialLinkTypeID::YOUTUBE,
                ],
                'google_plus'      => [
                    'url' => 'https://invalid-gplus.com/invalid',
                    'id'  => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                'imdb'             => [
                    'url' => 'https://invalid-imdb.com/invalid',
                    'id'  => SocialLinkTypeID::IMDB,
                ],
                'tumblr'           => [
                    'url' => 'https://invalid-tumblr.test/invalid',
                    'id'  => SocialLinkTypeID::TUMBLR,
                ],
                'vimeo'            => [
                    'url' => 'https://invalid-vimeo.com/invalid',
                    'id'  => SocialLinkTypeID::VIMEO,
                ],
                'instagram'        => [
                    'url' => 'https://invalid-instagram.com/invalid',
                    'id'  => SocialLinkTypeID::INSTAGRAM,
                ],
                'personal_website' => [
                    'url' => 'http://mysite.test',
                    'id'  => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('/crews', $data);

        $response->assertSessionHasErrors(
            [
                'reel'                         => 'The reel must be a valid Reel.',
                'socials.facebook.id'          => 'The socials.facebook.id field is required.',
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

    /** @test */
    public function create_vimeo_reel_cleaned()
    {
        $user = $this->getCrewUser();
        $data = $this->getCreateData(['reel' => 'https://vimeo.com/230046783']);

        $response = $this->actingAs($user)->post('/crews', $data);

        // assert general reel has been created
        $crew = Crew::where('user_id', $user->id)->first();
        $reel = $crew->reels->where('general', 1)->first();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://player.vimeo.com/video/230046783',
                'general' => 1,
            ],
            $reel->toArray()
        );
    }

    /** @test */
    public function update()
    {
        Storage::fake();

        $user     = $this->getCrewUser();
        $crew     = $this->getCrew($user);
        $resume   = $crew->resumes->where('general', 1)->first();
        $reel     = $crew->reels->where('general', 1)->first();
        $oldFiles = [
            'photo'  => $crew->photo,
            'resume' => $resume->url,
        ];
        $data     = $this->getUpdateData();

        $response = $this->actingAs($user)->put('/crews/' . $crew->id, $data);

        // assert response
        $response->assertSuccessful();

        // assert crew data
        $crew->refresh();

        $this->assertArraySubset(
            [
                'bio'   => 'updated bio',
                'photo' => 'photos/' . $user->uuid . '/' . $data['photo']->hashName(),
            ],
            $crew->toArray()
        );
        Storage::assertMissing($oldFiles['photo']);
        Storage::assertExists($crew->photo);

        // assert general resume
        $resume->refresh();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $user->uuid . '/' . $data['resume']->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );
        Storage::assertMissing($oldFiles['resume']);
        Storage::assertExists($resume->url);

        // assert reel
        $reel->refresh();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://www.youtube.com/embed/WI5AF1DCQlc',
                'general' => 1,
            ],
            $reel->toArray()
        );

        // assert socials
        $this->assertCount(9, $crew->social);
        $this->assertArraySubset(
            [
                [
                    'url'                 => 'https://www.facebook.com/new-castingcallsamerica/',
                    'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
                ],
                [
                    'url'                 => 'https://twitter.com/new-casting_america',
                    'social_link_type_id' => SocialLinkTypeID::TWITTER,
                ],
                [
                    'url'                 => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJwNEW',
                    'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
                ],
                [
                    'url'                 => 'https://plus.google.com/+marvel-new',
                    'social_link_type_id' => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                [
                    'url'                 => 'http://www.imdb.com/name/nm0000134/-updated',
                    'social_link_type_id' => SocialLinkTypeID::IMDB,
                ],
                [
                    'url'                 => 'http://new-updated.tumblr.com',
                    'social_link_type_id' => SocialLinkTypeID::TUMBLR,
                ],
                [
                    'url'                 => 'https://vimeo.com/new-mackevision',
                    'social_link_type_id' => SocialLinkTypeID::VIMEO,
                ],
                [
                    'url'                 => 'https://www.instagram.com/new-castingamerica/',
                    'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
                ],
                [
                    'url'                 => 'https://new-castingcallsamerica.com',
                    'social_link_type_id' => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
            $crew->social->toArray()
        );
    }

    /** @test */
    public function update_without_photo()
    {
        Storage::fake();

        $user         = $this->getCrewUser();
        $crew         = $this->getCrew($user);
        $oldCrewPhoto = $crew->photo;
        $data         = $data = $this->getUpdateData(['photo' => null]);

        $response = $this->actingAs($user)->put('/crews/' . $crew->id, $data);

        $response->assertSuccessful();

        $crew->refresh();

        $this->assertArraySubset(
            [
                'bio'   => 'updated bio',
                'photo' => $oldCrewPhoto,
            ],
            $crew->toArray()
        );
    }

    /** @test */
    public function update_without_existing_resume()
    {
        Storage::fake();

        $user = $this->getCrewUser();
        $crew = $this->getCrew($user, ['resume' => null]);
        $data = $this->getUpdateData();

        $response = $this->actingAs($user)->put('/crews/' . $crew->id, $data);

        // assert general resume
        $resume = $crew->resumes->where('general', 1)->first();

        $this->assertArraySubset(
            [
                'url'     => 'resumes/' . $user->uuid . '/' . $data['resume']->hashName(),
                'crew_id' => $crew->id,
                'general' => 1,
            ],
            $resume->toArray()
        );
        Storage::assertExists($resume->url);
    }


    /** @test */
    public function update_incomplete_socials()
    {
        Storage::fake();

        $user = $this->getCrewUser();
        $crew = $this->getCrew($user, ['resume' => null]);
        $data = $this->getUpdateData([
            'socials.youtube.url'          => '',
            'socials.personal_website.url' => '',
        ]);

        $response = $this->actingAs($user)->put('/crews/' . $crew->id, $data);

        $this->assertCount(7, $crew->social);
        $this->assertArraySubset(
            [
                [
                    'url'                 => 'https://www.facebook.com/new-castingcallsamerica/',
                    'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
                ],
                [
                    'url'                 => 'https://twitter.com/new-casting_america',
                    'social_link_type_id' => SocialLinkTypeID::TWITTER,
                ],
                [
                    'url'                 => 'https://plus.google.com/+marvel-new',
                    'social_link_type_id' => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                [
                    'url'                 => 'http://www.imdb.com/name/nm0000134/-updated',
                    'social_link_type_id' => SocialLinkTypeID::IMDB,
                ],
                [
                    'url'                 => 'http://new-updated.tumblr.com',
                    'social_link_type_id' => SocialLinkTypeID::TUMBLR,
                ],
                [
                    'url'                 => 'https://vimeo.com/new-mackevision',
                    'social_link_type_id' => SocialLinkTypeID::VIMEO,
                ],
                [
                    'url'                 => 'https://www.instagram.com/new-castingamerica/',
                    'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
                ],
            ],
            $crew->social->toArray()
        );
    }

    /** @test */
    public function update_without_reel()
    {
        Storage::fake();

        $user = $this->getCrewUser();
        $crew = $this->getCrew($user, ['reel' => null]);
        $data = $this->getUpdateData();

        $response = $this->actingAs($user)->put('/crews/' . $crew->id, $data);

        // assert data
        $reel = $crew->reels->where('general', 1)->first();

        $this->assertArraySubset(
            [
                'crew_id' => $crew->id,
                'url'     => 'https://www.youtube.com/embed/WI5AF1DCQlc',
                'general' => 1,
            ],
            $reel->toArray()
        );
    }

    /**
     * @return \App\Models\User
     * @throws \Exception
     */
    protected function getCrewUser()
    {
        $user = factory(User::class)->create();

        app(AuthServices::class)->createByRoleName(
            Role::CREW,
            $user,
            $this->getCurrentSite()
        );

        return $user;
    }

    /**
     * @param array $customData
     *
     * @return array
     */
    public function getCreateData($customData = [])
    {
        $data = [
            'bio'     => 'some bio',
            'photo'   => UploadedFile::fake()->image('photo.png'),
            'resume'  => UploadedFile::fake()->create('resume.pdf'),
            'reel'    => 'http://www.youtube.com/embed/G8S81CEBdNs',
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

        foreach ($customData as $key => $value) {
            array_set($data, $key, $value);
        }

        return $data;
    }

    /**
     * @todo delete
     *
     * @param \App\Models\User $user
     *
     * @param array            $customData
     *
     * @return \App\Models\Crew
     */
    protected function getCrew(User $user, array $customData = [])
    {
        $data = $this->getCreateData();

        foreach ($customData as $key => $value) {
            array_set($data, $key, $value);
        }

        $crew = app(CrewsServices::class)->processCreate($data, $user);

        return $crew;
    }

    /**
     * @param array $customData
     *
     * @return array
     */
    public function getUpdateData($customData = [])
    {
        $data = [
            'bio'     => 'updated bio',
            'photo'   => UploadedFile::fake()->image('new-photo.png'),
            'resume'  => UploadedFile::fake()->create('new-resume.pdf'),
            'reel'    => 'https://www.youtube.com/embed/WI5AF1DCQlc',
            'socials' => [
                'facebook'         => [
                    'url' => 'https://www.facebook.com/new-castingcallsamerica/',
                    'id'  => SocialLinkTypeID::FACEBOOK,
                ],
                'twitter'          => [
                    'url' => 'https://twitter.com/new-casting_america',
                    'id'  => SocialLinkTypeID::TWITTER,
                ],
                'youtube'          => [
                    'url' => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJwNEW',
                    'id'  => SocialLinkTypeID::YOUTUBE,
                ],
                'google_plus'      => [
                    'url' => 'https://plus.google.com/+marvel-new',
                    'id'  => SocialLinkTypeID::GOOGLE_PLUS,
                ],
                'imdb'             => [
                    'url' => 'http://www.imdb.com/name/nm0000134/-updated',
                    'id'  => SocialLinkTypeID::IMDB,
                ],
                'tumblr'           => [
                    'url' => 'http://new-updated.tumblr.com',
                    'id'  => SocialLinkTypeID::TUMBLR,
                ],
                'vimeo'            => [
                    'url' => 'https://vimeo.com/new-mackevision',
                    'id'  => SocialLinkTypeID::VIMEO,
                ],
                'instagram'        => [
                    'url' => 'https://www.instagram.com/new-castingamerica/',
                    'id'  => SocialLinkTypeID::INSTAGRAM,
                ],
                'personal_website' => [
                    'url' => 'https://new-castingcallsamerica.com',
                    'id'  => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
        ];

        foreach ($customData as $key => $value) {
            array_set($data, $key, $value);
        }

        return $data;
    }
}
