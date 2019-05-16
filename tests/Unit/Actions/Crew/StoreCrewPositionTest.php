<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\StoreCrewPosition;
use App\Models\Crew;
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
        $crew = factory(Crew::class)->create([
            'user_id' => $user->id,
        ]);
        $position = factory(Position::class)->create();

        $data = [
            'position_id'       => $position->id,
            'bio'               => 'This is the bio',
            'gear'              => 'This is the gear',
            'reel_link'         => 'https://www.youtube.com/embed/G8S81CEBdNs',
            'union_description' => 'This is the union description',
        ];

        // when
        app(StoreCrewPosition::class)->execute($crew, $position, $data);

        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        // then
        $this->assertDatabaseHas('crew_position', [
            'crew_id'           => $crew->id,
            'position_id'       => $position->id,
            'details'           => 'This is the bio',
            'union_description' => 'This is the union description',
        ]);

        $this->assertDatabaseHas('crew_gears', [
            'crew_id'          => $crew->id,
            'description'      => 'This is the gear',
            'crew_position_id' => $crewPosition->id,
        ]);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id'           => $crew->id,
            'path'              => $data['reel_link'],
            'general'           => false,
            'crew_position_id'  => $crewPosition->id,
        ]);
    }
}
