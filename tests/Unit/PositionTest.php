<?php

namespace Tests\Unit;

use App\Models\Crew;
use App\Models\Position;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Department;
use Tests\Support\SeedDatabaseAfterRefresh;
use App\Models\CrewPosition;

class PositionTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh, WithFaker;
    /**
     * @test
     */
    public function crews()
    {
        // given
        $position = factory(Position::class)->create();
        $crew = factory(Crew::class)->create();
        $crewPosition = factory(CrewPosition::class)->make();

        // when
        $position->crews()->attach($crew, [
            'details' => $crewPosition->details,
            'union_description' => $crewPosition->union_description,
        ]);

        // then
        $this->assertEquals($crew->id, $position->crews->first()->id);
        $this->assertDatabaseHas('crew_positions', [
            'crew_id' => $crew->id,
            'position_id' => $position->id,
            'details' => $crewPosition->details,
            'union_description' => $crewPosition->union_description
        ]);
    }
}