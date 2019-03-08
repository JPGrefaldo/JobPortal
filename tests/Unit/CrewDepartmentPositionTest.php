<?php

namespace Tests\Unit;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewDepartmentPositionTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        WithFaker;

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewPositionController::applyFor
     */
    public function apply_for()
    {
        $crew = $this->createCrew();
        $position = factory(Position::class)->create();

        $data = [
            'position_id' => $position->id,
            'bio' => 'This is the bio',
            'gear' => 'This is the gear',
            'union_description' => 'Some union description',
            'reel_link' => 'This is the reel link',
        ];

        $response = $this->actingAs($crew)
            ->postJson(route('crew-position.store', $position), $data);

        $response->assertSuccessful();

        $this->assertDatabaseHas('crew_position', [
            'crew_id' => $crew->id,
            'details' => $data['bio'],
            'union_description' => $data['union_description']
        ]);

        $this->assertDatabaseHas('crew_gears', [
            'crew_id' => $crew->id,
            'description' => $data['gear'],
        ]);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id' => $crew->id,
            'url' => $data['reel_link'],
        ]);
    }
}
