<?php

namespace Tests\Unit\Actions\Crew;

use Illuminate\Support\Arr;
use App\Actions\Crew\SaveCrew;
use App\Actions\Crew\SaveCrewReel;
use App\Actions\Crew\SaveCrewSocials;
use App\Actions\Crew\StoreCrew;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StoreCrewTest extends TestCase
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
     * @covers \App\Actions\StoreCrew::execute
     */
    public function execute()
    {
        // given
        $data = $this->getCreateData();

        // when
        app(StoreCrew::class)->execute($this->user, $data);

        // then
        $saveCrewMock = \Mockery::mock(SaveCrew::class);
        $saveCrewMock->shouldReceive('execute');

        $this->assertTrue($this->user->hasRole(Role::CREW));

        $saveCrewResumeMock = \Mockery::mock(SaveCrewResume::class);
        $saveCrewResumeMock->shouldReceive('execute');

        $saveCrewReelMock = \Mockery::mock(SaveCrewReel::class);
        $saveCrewReelMock->shouldReceive('execute');

        $saveCrewSocialsMock = \Mockery::mock(SaveCrewSocials::class);
        $saveCrewSocialsMock->shouldReceive('execute');
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrew::execute
     */
    public function only_bio_and_photo_are_required()
    {
        // given
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
        app(StoreCrew::class)->execute($this->user, $data);

        // then
        $crew = $this->user->crew;

        $saveCrewMock = \Mockery::mock(SaveCrew::class);
        $saveCrewMock->shouldReceive('execute');

        $this->assertTrue($this->user->hasRole(Role::CREW));

        $this->assertCount(0, $crew->resumes);
        $this->assertCount(0, $crew->reels);
        $this->assertCount(0, $crew->socials);
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
            Arr::set($data, $key, $value);
        }

        return $data;
    }
}
