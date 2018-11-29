<?php

namespace Tests\Unit;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

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
        $this->assertDatabaseHas('crew_position', [
            'crew_id' => $crew->id,
            'position_id' => $position->id,
            'details' => $crewPosition->details,
            'union_description' => $crewPosition->union_description
        ]);
    }

    /**
     * @test
     */
    public function department()
    {
        // given
        $department = factory(Department::class)->create();

        // when
        $position = factory(Position::class)->create([
            'department_id' => $department->id,
        ]);

        // then
        $this->assertEquals($department->name, $position->department->name);
    }
}
