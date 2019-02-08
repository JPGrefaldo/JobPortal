<?php

namespace Tests\Unit;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use App\Models\CrewGear;
use App\Models\CrewReel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;

class CrewDepartmentPositionTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        WithFaker;
    /**
     * @test
     * @covers \App\Models\CrewPosition
     */
    public function add_position_to_crews()
    {
        $crewPosition = factory(CrewPosition::class)->make();
        $position = factory(Position::class)->create();
        $crew = factory(Crew::class)->create();
        $crewGear = factory(CrewGear::class)->make();
        $crewReel = factory(CrewReel::class)->make();

        $position->crews()->attach($crew, [
            'details' => $crewPosition->details,
            'union_description' => $crewPosition->union_description,
        ]);

        $crewGear->crew()->attach($crew,[
            'crew_id' => $crew->id,
            'description' => $crewGear->gear,
            'crew_position_id' => $crewPosition->id,
        ]);

        $crewReel->crew()->attach($crew,[
            'crew_id' => $crew->id,
            'url' => $crewReel->reel,
            'crew_position_id' => $crewPosition->id,
        ]);

        $this->assertEquals($crew->id, $position->crews->first()->id);
        $this->assertDatabaseHas('crew_position', [
            'crew_id' => $crew->id,
            'position_id' => $position->id,
            'details' => $crewPosition->details,
            'union_description' => $crewPosition->union_description
        ]);
        $this->assertDatabaseHas('crew_reel', [
            'crew_id' => $crew->id,
            'url' => $crewReel->reel,
            'crew_position_id' => $crewPosition->id
        ]);
        $this->assertDatabaseHas('crew_gear', [
            'crew_id' => $crew->id,
            'description' => $crewGear->gear,
            'crew_position_id' => $crewPosition->id,
        ]);
    }

}
