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
        $data = $this->getUpdateCrewData();

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
        $data = $this->getUpdateCrewData([
            'reel_file' => UploadedFile::fake()->create('new-reel.mp4'),
        ]);

        app(StoreCrewReel::class)->execute($this->models['crew'], $data);

        $expectedPath = $this->models['crew']->user->hash_id . '/reels/'. $data['reel_file']->hashName();

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
        $data = $this->getUpdateCrewData();

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
        $data = $this->getUpdateCrewData([
            'reel_file' => UploadedFile::fake()->create('new-reel.mp4'),
        ]);

        app(StoreCrewReel::class)->execute($this->models['crew'], $data);

        $expectedPath = $this->models['crew']->user->hash_id . '/reels/'. $data['reel_file']->hashName();

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
        $data = $this->getUpdateCrewData();

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

        $data = $this->getUpdateCrewData([
            'reel_file' => UploadedFile::fake()->create('new-reel.mp4'),
        ]);

        app(StoreCrewReel::class)->execute($this->models['crew'], $data);

        Storage::disk('s3')->assertMissing($reelPath);

        $expectedPath = $this->models['crew']->user->hash_id . '/reels/'. $data['reel_file']->hashName();

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
            'reel_link' => 'https://www.youtube.com/watch?v=2-_rLbU6zJo',
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
            'reel_link' => 'https://vimeo.com/230046783',
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
            'reel_file' => UploadedFile::fake()->create('reel.mp4'),
        ];

        // when
        app(StoreCrewReel::class)->execute($this->models['crew'], $data);

        // then
        $expectedPath = $this->models['crew']->user->hash_id . '/reels/'. $data['reel_file']->hashName();

        Storage::disk('s3')->assertExists($expectedPath);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $this->models['crew']->id,
            'path'             => $expectedPath,
            'general'          => true,
            'crew_position_id' => null,
        ]);
    }
}
