<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\DeleteCrewPhoto;
use App\Actions\Crew\StoreCrewPhoto;
use App\Models\Crew;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\CreatesCrewModel;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class DeleteCrewPhotoTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh,  CreatesCrewModel;

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
     * @covers App\Actions\Crew\DeleteCrewPhoto::execute
     */
    public function execute()
    {
        // Given
        $this->models = $this->createCompleteCrew();

        $data = [
            'photo' => UploadedFile::fake()->image('my-photo.png'),
        ];

        // Create an entry 
        app(StoreCrewPhoto::class)->execute($this->models['crew'], $data);

        //Then we assert the entry exists on s3
        Storage::drive('s3')->assertExists($this->models['crew']->photo_path);

        // Then we delete the entry we just created
        app(DeleteCrewPhoto::class)->execute($this->models['crew']);

        // Then assert photo is deleted from s3
         Storage::drive('s3')->assertMissing($this->models['crew']->photo_path);

        // Then assert photo_path missing
        $this->assertDatabaseHas('crews', [
            'id'       => $this->models['crew']->id,
            'user_id'  => $this->models['crew']->user_id,
            'bio'      => null, 
            'photo_path' => ''
        ]);
    }
}
