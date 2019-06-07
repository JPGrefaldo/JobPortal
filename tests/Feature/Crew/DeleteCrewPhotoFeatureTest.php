<?php

namespace Tests\Feature\Crew;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class DeleteCrewPhotoFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('s3');

        $user = $this->createCrew();

        $this->user = $user;
    }

    /**
     * @test
     */
    public function destroy()
    {
        // when
        $this->actingAs($this->user)
            ->delete(route('crew.photo.destroy', $this->user->id))
            ->assertSuccessful();
    }
}
