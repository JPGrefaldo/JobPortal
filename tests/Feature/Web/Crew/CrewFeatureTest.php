<?php

namespace Tests\Feature\Web\Crew;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('s3');

        $this->user = $this->createCrew();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::index
     */
    public function index()
    {
        $this->actingAs($this->user)
            ->get(route('crew.profile.index'))
            ->assertSuccessful()
            ->assertSee('My profile')
            // ->assertViewIs('crew.profile.profile-index')
            ->assertSee('COMPLETE YOUR ACCOUNT');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::create
     */
    public function create()
    {
        $this->actingAs($this->user)
            ->get(route('crew.profile.create'))
            ->assertRedirect(route('crew.profile.edit'));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function store()
    {
        $data = $this->get_store_data();

        $response = $this->actingAs($this->user)
            ->post(route('crew.profile.store'), $data);

        $response->assertRedirect(route('crew.profile.edit'));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::show
     */
    public function show()
    {
        $anotherCrew = $this->createCrew();

        $this->actingAs($this->user)
            ->get(route('crew.profile.show', $anotherCrew))
            ->assertSuccessful()
            // ->assertViewIs('crew.profile.profile-show')
            ->assertSee('IMDb profile');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::edit
     */
    public function edit()
    {
        $this->actingAs($this->user)
            ->get(route('crew.profile.edit'))
            ->assertSuccessful()
            ->assertSee('Edit profile')
            // ->assertViewIs('crew.profile.profile-edit')
            ->assertSee('COMPLETE YOUR ACCOUNT');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_not_required()
    {
        // given
        // $this->withoutExceptionHandling();

        $data = $this->get_store_data([
            'resume'                       => '',
            'reel'                         => '',
            'socials.facebook.url'         => '',
            'socials.twitter.url'          => '',
            'socials.youtube.url'          => '',
            'socials.imdb.url'             => '',
            'socials.tumblr.url'           => '',
            'socials.vimeo.url'            => '',
            'socials.instagram.url'        => '',
            'socials.personal_website.url' => '',
        ]);

        // when
        $response = $this->actingAs($this->user)
            ->post(route('crew.profile.store'), $data);

        // then
        $response->assertRedirect(route('crew.profile.edit'));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_invalid_data()
    {
        // $this->withoutExceptionHandling();

        $data = $this->get_store_data([
            'photo'                        => UploadedFile::fake()->create('image.php'),
            'resume'                       => UploadedFile::fake()->create('resume.php'),
            'reel_file'                    => UploadedFile::fake()->create('video.php'),
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
            ->post(route('crew.profile.store'), $data);

        // then
        $response->assertSessionHasErrors([
            'photo'                        => 'The photo must be an image.',
            'resume'                       => 'The resume must be a file of type: pdf, doc, docx.',
            'reel_link'                    => 'The reel must be a valid Reel.',
            'reel_file'                    => 'The reel file must be a file of type: mp4, avi, wmv .',
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
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_youtube_cleaned()
    {
        // given
        $data = $this->get_store_data([
            'reel'                => 'https://www.youtube.com/watch?v=2-_rLbU6zJo',
            'socials.youtube.url' => 'https://www.youtube.com/watch?v=G8S81CEBdNs',
        ]);

        // when
        $response = $this->actingAs($this->user)
            ->post(route('crew.profile.store'), $data);

        // then
        $response->assertRedirect(route('crew.profile.edit'));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_vimeo_reel_cleaned()
    {
        // given
        $data = $this->get_store_data([
            'reel' => 'https://vimeo.com/230046783',
        ]);

        // when
        $response = $this->actingAs($this->user)
            ->post(route('crew.profile.store'), $data);

        // then
        $response->assertRedirect(route('crew.profile.edit'));
    }

    /**
     * @param array $customData
     *
     * @return array
     */
    public function get_store_data($customData = [])
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
                    'url' => 'https://www.imdb.com/name/nm0000134/',
                    'id'  => SocialLinkTypeID::IMDB,
                ],
                'tumblr'           => [
                    'url' => 'http://test.tumblr.com',
                    'id'  => SocialLinkTypeID::TUMBLR,
                ],
                'vimeo'            => [
                    'url' => 'https://vimeo.com/337361057',
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

        return $this->customize_data($data, $customData);
    }

    /**
     * @param $data
     * @param $customData
     *
     * @return mixed
     */
    protected function customize_data($data, $customData)
    {
        foreach ($customData as $key => $value) {
            Arr::set($data, $key, $value);
        }

        return $data;
    }
}
