<?php

namespace Tests\Feature\Crew;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewUpdateFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('s3');

        $user = $this->createCrew();
        $data = $this->getCreateData();

        $this->user = $user;

        $this->actingAs($this->user)
            ->get(route('crew.profile.create'), $data);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::update
     */
    public function update()
    {
        // given
        // $this->withoutExceptionHandling();

        $data = $this->getUpdateData();

        // when
        $response = $this->actingAs($this->user)
            ->put(route('crew.profile.update'), $data);

        // then
        $response->assertRedirect(route('crew.profile.create'));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::update
     */
    public function crew_photo_can_be_unpersisted()
    {
        // given
        $data = $this->getUpdateData(['photo' => '']);

        // when
        $response = $this->actingAs($this->user)
            ->put(route('crew.profile.update'), $data);

        // then
        $response->assertRedirect(route('crew.profile.create'));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::update
     */
    public function socials_can_be_deleted()
    {
        $data = $this->getUpdateData([
            'socials.youtube.url'          => '',
            'socials.personal_website.url' => '',
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('crew.profile.update'), $data);

        $response->assertRedirect(route('crew.profile.create'));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::update
     */
    public function youtube_is_formatted_before_updated()
    {
        // given
        $data = $this->getUpdateData([
            'reel'                => 'https://www.youtube.com/watch?v=2-_rLbU6zJo',
            'socials.youtube.url' => 'https://www.youtube.com/watch?v=G8S81CEBdNs',
        ]);

        // when
        $response = $this->actingAs($this->user)
            ->put(route('crew.profile.update', $this->user->crew), $data);

        // then
        $response->assertRedirect(route('crew.profile.create'));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::update
     */
    public function vimeo_is_formatted_before_updated()
    {
        // given
        $data = $this->getUpdateData(['reel' => 'https://vimeo.com/230046783']);

        // when
        $response = $this->actingAs($this->user)
            ->put(route('crew.profile.update', $this->user->crew), $data);

        // then
        $response->assertRedirect(route('crew.profile.create'));
    }

    /**
     * @test
     * @covers App\Http\Controllers\Crew\CrewPositionController::update
     */
    public function update_crew_position()
    {
        $crewPosition = factory(\App\Models\CrewPosition::class)->create();

        $this->actingAs($this->user)
            ->put(route('crew-position.update', $crewPosition->id), [
                'bio' => 'This is my bio',
            ])->assertRedirect(route('crew.profile.create'));
    }

    /**
     * @test
     * @covers App\Http\Controllers\Crew\CrewPositionController::update
     */
    public function update_crew_position_resume_file_required_when_uploading_resume()
    {
        $crewPosition = factory(\App\Models\CrewPosition::class)->create();

        $this->actingAs($this->user)
            ->put(route('crew-position.update', $crewPosition->id), [
                'bio'    => 'This is my bio',
                'resume' => UploadedFile::fake()->create('resume.jpg'),
                'method' => 'put'
            ])->assertSessionHasErrors([
                'resume'
            ]);
    }

    /**
     * @test
     * @covers App\Http\Controllers\Crew\CrewPositionController::update
     */
    public function update_crew_position_valid_reel_link_required()
    {
        $crewPosition = factory(\App\Models\CrewPosition::class)->create();

        $this->actingAs($this->user)
            ->put(route('crew-position.update', $crewPosition->id), [
                'bio'       => 'This is my bio',
                'reel_link' => 'http://www.facebook.com/link',
                'method'    => 'put'
            ])->assertSessionHasErrors([
                'reel_link'
            ]);
    }

    /**
     * @test
     * @covers App\Http\Controllers\Crew\CrewPositionController::applyFor
     */
    public function create_crew_position_requires_resume_file()
    {
        $crewPosition = factory(\App\Models\CrewPosition::class)->create();

        $this->actingAs($this->user)
            ->put(route('crew-position.update', $crewPosition->id), [
                'bio' => 'This is my bio',
            ])->assertSessionHasErrors([
                'resume'
            ]);
    }

    /**
     * @test
     * @covers App\Http\Controllers\Crew\CrewPositionController::applyFor
     */
    public function create_crew_position_requires_bio()
    {
        $crewPosition = factory(\App\Models\CrewPosition::class)->create();

        $this->actingAs($this->user)
            ->put(route('crew-position.update', $crewPosition->id), [
                'resume' => UploadedFile::fake()->create('resume.docx'),
            ])->assertSessionHasErrors([
                'bio'
            ]);
    }

    /**
     * @test
     * @covers App\Http\Controllers\Crew\CrewPositionController::update
     */
    public function update_crew_position_reel_file_must_be_valid()
    {
        $crewPosition = factory(\App\Models\CrewPosition::class)->create();

        $this->actingAs($this->user)
            ->put(route('crew-position.update', $crewPosition->id), [
                'bio'       => 'This is my bio',
                'reel_file' => UploadedFile::fake()->create('resume.jpg'),
                'method'    => 'put',
            ])->assertSessionHasErrors([
                'reel_file'
            ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::update
     */
    public function update_invalid_data()
    {
        $data = $this->getUpdateData([
            'photo'                        => UploadedFile::fake()->create('image.php'),
            'resume'                       => UploadedFile::fake()->create('resume.php'),
            'reel_link'                    => 'https://some-invalid-reel.com',
            'socials.facebook.url'         => 'https://invalid-facebook.com/invalid',
            'socials.twitter.url'          => 'https://invalid-twitter.com/invalid',
            'socials.youtube.url'          => 'https://invalid-youtube.com/invalid',
            'socials.google_plus.url'      => 'https://invalid-gplus.com/invalid',
            'socials.imdb.url'             => 'https://invalid-imdb.com/invalid',
            'socials.tumblr.url'           => 'https://invalid-tumblr.test/invalid',
            'socials.vimeo.url'            => 'https://invalid-vimeo.com/invalid',
            'socials.instagram.url'        => 'https://invalid-instagram.com/invalid',
            'socials.personal_website.url' => 'http://mysite.test',
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('crew.profile.update', $this->user->crew), $data);

        $response->assertSessionHasErrors([
            'photo'                        => 'The photo must be an image.',
            'resume'                       => 'The resume must be a file of type: pdf, doc, docx.',
            'reel_link'                    => 'The reel must be a valid Reel.',
            'socials.facebook.url'         => 'facebook must be a valid Facebook URL.',
            'socials.twitter.url'          => 'twitter must be a valid Twitter URL.',
            'socials.youtube.url'          => 'youtube must be a valid YouTube URL.',
            'socials.imdb.url'             => 'imdb must be a valid IMDB URL.',
            'socials.tumblr.url'           => 'tumblr must be a valid Tumblr URL.',
            'socials.vimeo.url'            => 'vimeo must be a valid Vimeo URL.',
            'socials.instagram.url'        => 'instagram must be a valid Instagram URL.',
            'socials.personal_website.url' => 'The website is invalid.',
        ]);
    }


    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::update
     */
    public function update_unauthorized()
    {
        $randomUser = $this->createUser();
        $data = $this->getUpdateData();

        $response = $this->actingAs($randomUser)
            ->put(route('crew.profile.update', $this->user->crew), $data);

        $response->assertForbidden();
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
                    'url' => 'https://www.instagram.com/new-castingamerica',
                    'id'  => SocialLinkTypeID::INSTAGRAM,
                ],
                'personal_website' => [
                    'url' => 'https://castingcallsamerica.com',
                    'id'  => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
        ];

        return $this->customizeData($data, $customData);
    }

    /**
     * @param $data
     * @param $customData
     *
     * @return mixed
     */
    protected function customizeData($data, $customData)
    {
        foreach ($customData as $key => $value) {
            Arr::set($data, $key, $value);
        }

        return $data;
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
                    'url' => 'https://twitter.com/new_casting_america',
                    'id'  => SocialLinkTypeID::TWITTER,
                ],
                'youtube'          => [
                    'url' => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJwNEW',
                    'id'  => SocialLinkTypeID::YOUTUBE,
                ],
                'imdb'             => [
                    'url' => 'https://www.imdb.com/name/nm0000134/-updated',
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
                    'url' => 'https://www.instagram.com/newcastingamerica/',
                    'id'  => SocialLinkTypeID::INSTAGRAM,
                ],
                'personal_website' => [
                    'url' => 'https://new-castingcallsamerica.com',
                    'id'  => SocialLinkTypeID::PERSONAL_WEBSITE,
                ],
            ],
        ];

        return $this->customizeData($data, $customData);
    }
}
