<?php

namespace Tests\Feature\Crew;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

/**
 * @group CrewsFeatureTest
 */
class CrewFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp()
    {
        parent::setUp();

        Storage::fake('s3');

        $this->user = $this->createUser();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create()
    {
        // given
        // $this->withoutExceptionHandling();

        $data = $this->getCreateData();

        // when
        $response = $this->actingAs($this->user)
            ->post(route('crews.store'), $data);

        // then
        $response->assertSuccessful();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_not_required()
    {
        // given
        // $this->withoutExceptionHandling();

        $data = $this->getCreateData([
            'resume'                       => '',
            'reel'                         => '',
            'socials.facebook.url'         => '',
            'socials.twitter.url'          => '',
            'socials.youtube.url'          => '',
            'socials.google_plus.url'      => '',
            'socials.imdb.url'             => '',
            'socials.tumblr.url'           => '',
            'socials.vimeo.url'            => '',
            'socials.instagram.url'        => '',
            'socials.personal_website.url' => '',
        ]);

        // when
        $response = $this->actingAs($this->user)
            ->post(route('crews.store'), $data);

        //  then
        $response->assertSuccessful();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_invalid_data()
    {
        $data = $this->getCreateData([
            'photo'                        => UploadedFile::fake()->create('image.php'),
            'resume'                       => UploadedFile::fake()->create('resume.php'),
            'reel'                         => 'https://some-invalid-reel.com',
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
            ->post(route('crews.store'), $data);

        $response->assertSessionHasErrors([
            'photo'                        => 'The photo must be an image.',
            'resume'                       => 'The resume must be a file of type: pdf, doc, docx.',
            'reel'                         => 'The reel must be a valid Reel.',
            'socials.facebook.url'         => 'facebook must be a valid Facebook URL.',
            'socials.twitter.url'          => 'twitter must be a valid Twitter URL.',
            'socials.youtube.url'          => 'youtube must be a valid YouTube URL.',
            'socials.google_plus.url'      => 'google plus must be a valid Google Plus URL.',
            'socials.imdb.url'             => 'imdb must be a valid IMDB URL.',
            'socials.tumblr.url'           => 'tumblr must be a valid Tumblr URL.',
            'socials.vimeo.url'            => 'vimeo must be a valid Vimeo URL.',
            'socials.instagram.url'        => 'instagram must be a valid Instagram URL.',
            'socials.personal_website.url' => 'The website is invalid.',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_youtube_cleaned()
    {
        // given
        $data = $this->getCreateData([
            'reel'                => 'https://www.youtube.com/watch?v=2-_rLbU6zJo',
            'socials.youtube.url' => 'https://www.youtube.com/watch?v=G8S81CEBdNs',
        ]);

        // when
        $response = $this->actingAs($this->user)
            ->post(route('crews.store'), $data);

        // then
        $response->assertSuccessful();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_vimeo_reel_cleaned()
    {
        // given
        $data = $this->getCreateData([
            'reel' => 'https://vimeo.com/230046783',
        ]);

        // when
        $response = $this->actingAs($this->user)
            ->post(route('crews.store'), $data);

        // then
        $response->assertSuccessful();
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
                    'url' => 'https://www.instagram.com/castingamerica/',
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
            array_set($data, $key, $value);
        }

        return $data;
    }
}
