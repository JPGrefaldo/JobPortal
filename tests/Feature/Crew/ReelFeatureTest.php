<?php

namespace Tests\Feature\Crew;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Support\SeedDatabaseAfterRefresh;
use App\Models\Position;
use Illuminate\Http\UploadedFile;

class ReelFeatureTest extends TestCase
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
     */
    public function destroy()
    {
        $position = factory(Position::class)->create();

        $data = [
            'resume'            => UploadedFile::fake()->create('resume.pdf'),
            'bio'               => 'This is the bio',
            'gear'              => 'This is the gear',
            'union_description' => 'Some union description',
            'reel_link'         => 'https://www.youtube.com/embed/G8S81CEBdNs',
        ];

        $this->actingAs($this->user)
            ->post(route('crew-position.store', $position->id), $data)
            ->assertSuccessful()
            ->assertJsonFragment([
                'message' => 'success',
            ]);

        $this->delete(route('crew-position.delete-reel', $position->id))
            ->assertSuccessful();
    }
}
