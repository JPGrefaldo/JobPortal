<?php

namespace Tests\Unit;

use App\Actions\Crew\StoreCrewPosition;
use App\Models\CrewPosition;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreCrewPositionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @covers App\Actions\Crew\StoreCrewPosition::execute
     */
    public function execute()
    {
        // given
        $user = $this->createUser();
        $crew = $user->crew;
        $position = factory(Position::class)->create();

        $data = [
            'position_id' => $position->id,
            'bio' => 'This is the bio',
            'gear' => 'This is the gear',
            'reel_link' => 'www.this-is-my-link.com',
        ];

        // when
        app(StoreCrewPosition::class)->execute();

        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position);

        // then
        $this->assertDatabaseHas('crew_position', [
            'crew_id' => $crew->id,
            'position_id' => $position->id,
            'description' => 'This is the bio',
            'union_description' => 'This is the union description',
        ]);

        $this->assertDatabaseHas('crew_gears', [
            'crew_id' => $crew->id,
            'position_id' => $position->id,
            'description' => 'This is the gear',
            'crew_position_id' => $crewPosition->id,
        ]);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id' => $crew->id,
            'url' => 'www.this-is-my-link.com',
            'general' => false,
            'crew_position_id' => $crewPosition->id,
        ]);
    }
}
