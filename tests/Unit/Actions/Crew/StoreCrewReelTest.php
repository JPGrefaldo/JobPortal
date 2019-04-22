<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\StoreCrewReel;
use App\Models\CrewReel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\Support\CreatesCrewModel;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StoreCrewReelTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        CreatesCrewModel;

    /**
     * @var array
     */
    public $models;

    public function setUp(): void
    {
        parent::setup();

        Storage::fake('s3');

        $this->models = $this->createCompleteCrew();
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewReel
     */
    public function blank_reel_can_be_updated_to_reel_link()
    {
        $data = $this->getUpdateData();

        app(StoreCrewReel::class)->execute($this->models['crew'], $data);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $this->models['crew']->id,
            'path'             => 'https://www.youtube.com/embed/WI5AF1DCQlc',
            'general'          => true,
            'crew_position_id' => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewReel::execute
     */
    public function blank_reel_can_be_updated_to_reel_file()
    {
        $data = $this->getUpdateData([
            'reel' => UploadedFile::fake()->create('new-reel.mp4'),
        ]);

        app(StoreCrewReel::class)->execute($this->models['crew'], $data);

        $expectedPath = $this->models['crew']->user->hash_id . '/reels/'. $data['reel']->hashName();

        Storage::disk('s3')->assertExists($expectedPath);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $this->models['crew']->id,
            'path'             => $expectedPath,
            'general'          => true,
            'crew_position_id' => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewReel::execute
     */
    public function reel_link_can_be_updated_to_reel_link()
    {
        $data = $this->getUpdateData();

        app(StoreCrewReel::class)->execute($this->models['crew'], $data);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $this->models['crew']->id,
            'path'             => 'https://www.youtube.com/embed/WI5AF1DCQlc',
            'general'          => true,
            'crew_position_id' => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewReel::execute
     */
    public function reel_link_can_be_updated_to_reel_file()
    {
        $data = $this->getUpdateData([
            'reel' => UploadedFile::fake()->create('new-reel.mp4'),
        ]);

        app(StoreCrewReel::class)->execute($this->models['crew'], $data);

        $expectedPath = $this->models['crew']->user->hash_id . '/reels/'. $data['reel']->hashName();

        Storage::disk('s3')->assertExists($expectedPath);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $this->models['crew']->id,
            'path'             => $expectedPath,
            'general'          => true,
            'crew_position_id' => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewReel::execute
     */
    public function reel_file_can_be_updated_to_reel_link()
    {
        $data = $this->getUpdateData();

        $reelPath = $this->models['user']->hash_id . '/reels/reel.mp4';

        Storage::disk('s3')->put($reelPath, 'some non-jpg content');
        Storage::disk('s3')->assertExists($reelPath);

        CrewReel::whereCrewId($this->models['crew']->id)->update([
            'path' => $reelPath,
        ]);

        app(StoreCrewReel::class)->execute($this->models['crew'], $data);

        Storage::disk('s3')->assertMissing($reelPath);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $this->models['crew']->id,
            'path'             => 'https://www.youtube.com/embed/WI5AF1DCQlc',
            'general'          => true,
            'crew_position_id' => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewReel::execute
     */
    public function reel_file_can_be_updated_to_reel_file()
    {

        $reelPath = $this->models['user']->hash_id . '/reels/reel.mp4';
        Storage::disk('s3')->put($reelPath, 'some non-jpg content');
        Storage::disk('s3')->assertExists($reelPath);

        CrewReel::whereCrewId($this->models['crew']->id)->update([
            'path' => $reelPath,
        ]);

        $data = $this->getUpdateData([
            'reel' => UploadedFile::fake()->create('new-reel.mp4'),
        ]);

        app(StoreCrewReel::class)->execute($this->models['crew'], $data);

        Storage::disk('s3')->assertMissing($reelPath);

        $expectedPath = $this->models['crew']->user->hash_id . '/reels/'. $data['reel']->hashName();

        Storage::disk('s3')->assertExists($expectedPath);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $this->models['crew']->id,
            'path'             => $expectedPath,
            'general'          => true,
            'crew_position_id' => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewReel::execute
     */
    public function youtube_is_formatted_before_stored()
    {
        // given
        $data = [
            'reel' => 'https://www.youtube.com/watch?v=2-_rLbU6zJo',
        ];

        // when
        app(StoreCrewReel::class)->execute($this->models['crew'], $data);

        // then
        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $this->models['crew']->id,
            'path'             => 'https://www.youtube.com/embed/2-_rLbU6zJo',
            'general'          => true,
            'crew_position_id' => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewReel::execute
     */
    public function vimeo_is_formatted_before_stored()
    {
        // given
        $data = [
            'reel' => 'https://vimeo.com/230046783',
        ];

        // when
        app(StoreCrewReel::class)->execute($this->models['crew'], $data);

        // then
        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $this->models['crew']->id,
            'path'             => 'https://player.vimeo.com/video/230046783',
            'general'          => true,
            'crew_position_id' => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewReel::execute
     */
    public function reel_files_can_be_persisted()
    {
        // given
        Storage::fake('s3');

        $data = [
            'reel' => UploadedFile::fake()->create('reel.mp4'),
        ];

        // when
        app(StoreCrewReel::class)->execute($this->models['crew'], $data);

        // then
        $expectedPath = $this->models['crew']->user->hash_id . '/reels/'. $data['reel']->hashName();

        Storage::disk('s3')->assertExists($expectedPath);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $this->models['crew']->id,
            'path'             => $expectedPath,
            'general'          => true,
            'crew_position_id' => null,
        ]);
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
    public function getCreateData($customData = [])
    {
        $data = [
            'socials' =>
            [
                'url' => 'https://www.facebook.com/castingcallsamerica/',
                'id'  => SocialLinkTypeID::FACEBOOK,
            ],
            [
                'url' => 'https://twitter.com/casting_america',
                'id'  => SocialLinkTypeID::TWITTER,
            ],
            [
                'url' => 'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJw',
                'id'  => SocialLinkTypeID::YOUTUBE,
            ],
            [
                'url' => 'http://www.imdb.com/name/nm0000134/',
                'id'  => SocialLinkTypeID::IMDB,
            ],
            [
                'url' => 'http://test.tumblr.com',
                'id'  => SocialLinkTypeID::TUMBLR,
            ],
            [
                'url' => 'https://vimeo.com/mackevision',
                'id'  => SocialLinkTypeID::VIMEO,
            ],
            [
                'url' => 'https://www.instagram.com/castingamerica/',
                'id'  => SocialLinkTypeID::INSTAGRAM,
            ],
            [
                'url' => 'https://castingcallsamerica.com',
                'id'  => SocialLinkTypeID::PERSONAL_WEBSITE,
            ],
        ];

        return $this->customizeData($data, $customData);
    }
}
