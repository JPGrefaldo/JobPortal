<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\StoreCrewPhoto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\CreatesCrewModel;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StoreCrewPhotoTest extends TestCase
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
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewPhoto::execute
     */
    public function overwrite_and_delete_old_photo()
    {
        $this->models = $this->createCompleteCrew();

        $data = [
            'photo' => UploadedFile::fake()->image('my-photo.png'),
        ];

        $old = $this->models['crew']->photo_path;

        Storage::drive('s3')->assertExists($old);

        app(StoreCrewPhoto::class)->execute($this->models['crew'], $data);

        $this->assertEquals(
            $this->models['crew']->refresh()->photo_path,
            $this->models['user']->hash_id . '/photos/' . $data['photo']->hashName()
        );
        Storage::drive('s3')->assertMissing($old);
        Storage::drive('s3')->assertExists($this->models['user']->hash_id . '/photos/' . $data['photo']->hashName());
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewPhoto::execute
     */
    public function new_user_with_no_old_photo()
    {
        $this->models = $this->createCompleteCrew([
            'crew' => [
                'photo_path' => '',
            ],
        ]);

        $data = [
            'photo' => UploadedFile::fake()->image('my-photo.png'),
        ];

        app(StoreCrewPhoto::class)->execute($this->models['crew'], $data);

        $this->assertEquals(
            $this->models['crew']->refresh()->photo_path,
            $this->models['user']->hash_id . '/photos/' . $data['photo']->hashName()
        );

        Storage::drive('s3')->assertExists($this->models['user']->hash_id . '/photos/' . $data['photo']->hashName());
    }
}
