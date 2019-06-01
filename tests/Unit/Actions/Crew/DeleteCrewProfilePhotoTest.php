<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\DeleteCrewProfilePhoto;
use App\Actions\Crew\StoreCrewPhoto;
use App\Models\Crew;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class DeleteCrewProfilePhotoTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers App\Actions\Crew\DeleteCrewProfilePhoto::execute
     */
    public function execute()
    {
        // Given
        Storage::fake('s3');

        $user = $this->createUser();
        $crew = factory(Crew::class)->create([
            'user_id' => $user->id,
        ]);

        $data = [
            'photo' => UploadedFile::fake()->image('my-photo.png'),
        ];

        // Create an entry 
        app(StoreCrewPhoto::class)->execute($crew, $data);

        // Then we delete the entry we just created
        app(DeleteCrewProfilePhoto::class)->execute($crew);

        // Then assert photo_path missing
        $this->assertDatabaseHas('crews', [
            'id'       => $crew->id,
            'user_id'  => $crew->user_id,
            'bio'      => null, 
            'photo_path' => ''
        ]);
    }
}
