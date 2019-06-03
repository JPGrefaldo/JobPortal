<?php

namespace Tests\Feature\Web\Crew;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewDepartmentPositionFeatureTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        WithFaker;

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewPositionController::store
     */
    public function store()
    {
        Storage::fake('s3');
        $crew     = $this->createCrew();
        $position = factory(Position::class)->create();

        $data = [
            'resume'            => UploadedFile::fake()->create('resume.pdf'),
            'bio'               => 'This is the bio',
            'gear'              => 'This is the gear',
            'union_description' => 'Some union description',
            'reel_link'         => 'https://www.youtube.com/embed/G8S81CEBdNs',
        ];

        $response = $this->actingAs($crew)
            ->postJson(route('crew-position.store', $position), $data);

        $response->assertSuccessful();

        $this->assertDatabaseHas('crew_position', [
            'crew_id'           => $crew->id,
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        $this->assertDatabaseHas('crew_gears', [
            'crew_id'     => $crew->id,
            'description' => $data['gear'],
        ]);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id' => $crew->id,
            'path'    => $data['reel_link'],
        ]);
    }
}
