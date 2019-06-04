<?php

namespace Tests\Feature\Web\Crew;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewGearFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_position_requires_gear()
    {
        $crew = $this->createCrew();
        $position = factory(Position::class)->create([
            'has_gear' => 1,
        ]);

        $data = [
            'position_id'       => $position->id,
            'bio'               => 'This is the bio',
            'resume'            => UploadedFile::fake()->create('resume.doc'),
            'union_description' => 'Some union description',
            'reel_link'         => 'http://www.youtube.com/embed/G8S81CEBdNs',
        ];

        $this->actingAs($crew)
            ->postJson(route('crew-position.store', $position), $data)
            ->assertJsonValidationErrors('gear');

        $this->assertDatabaseMissing('crew_position', [
            'crew_id'           => $crew->id,
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        $this->assertDatabaseMissing('crew_reels', [
            'crew_id' => $crew->id,
            'path'    => $data['reel_link'],
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_position_dont_require_gear()
    {
        $crew = $this->createCrew();
        $position = factory(Position::class)->create();

        $data = [
            'position_id'       => $position->id,
            'bio'               => 'This is the bio',
            'resume'            => UploadedFile::fake()->create('resume.doc'),
            'union_description' => 'Some union description',
            'reel_link'         => "http://www.youtube.com/embed/G8S81CEBdNs",
        ];

        $this->actingAs($crew)
            ->postJson(route('crew-position.store', $position), $data)
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('crew_position', [
            'crew_id'           => $crew->id,
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        $this->assertDatabaseMissing('crew_reels', [
            'crew_id' => $crew->id,
            'path'    => $data['reel_link'],
        ]);
    }
}
