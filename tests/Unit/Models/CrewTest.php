<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\Position;
use App\Models\CrewPosition;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;

class CrewTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh, WithFaker;

    /**
     * @test
     */
    public function positions()
    {
        // given
        $position = factory(Position::class)->create();
        $crew = factory(Crew::class)->create();
        $crewPosition = factory(CrewPosition::class)->make();

        // when
        $crew->positions()->attach($position, [
            'details' => $crewPosition->details,
            'union_description' => $crewPosition->union_description
        ]);

        // then
        $this->assertEquals($position->id, $crew->positions->first()->id);
        $this->assertDatabaseHas('crew_positions', [
            'crew_id' => $crew->id,
            'position_id' => $position->id,
            'details' => $crewPosition->details,
            'union_description' => $crewPosition->union_description
        ]);
    }

    /**
     * @test
     */
    public function applyFor()
    {
        // given
        $position = factory(Position::class)->create();
        $crew = factory(Crew::class)->create();
        $crewPosition = factory(CrewPosition::class)->make();

        // when
        $crew->applyFor($position, $crewPosition);

        // then
        $this->assertEquals($position->id, $crew->positions->first()->id);
        $this->assertDatabaseHas('crew_positions', [
            'crew_id' => $crew->id,
            'position_id' => $position->id,
            'details' => $crewPosition->details,
            'union_description' => $crewPosition->union_description
        ]);
    }
}
