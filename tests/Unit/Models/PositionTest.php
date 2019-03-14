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
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        WithFaker;

    /**
     * @test
     * @covers \App\Models\Position::crews
     */
    public function crews()
    {
        $position = factory(Position::class)->create();
        $crew = factory(Crew::class)->create();
        $crewPosition = factory(CrewPosition::class)->make();

        $position->crews()->attach($crew, [
            'details'           => $crewPosition->details,
            'union_description' => $crewPosition->union_description,
        ]);

        $this->assertEquals($crew->id, $position->crews->first()->id);
        $this->assertDatabaseHas('crew_position', [
            'crew_id'           => $crew->id,
            'position_id'       => $position->id,
            'details'           => $crewPosition->details,
            'union_description' => $crewPosition->union_description,
        ]);
    }

    /**
     * @test
     * @covers \App\Models\Position::department
     */
    public function department()
    {
        $department = factory(Department::class)->create();

        $position = factory(Position::class)->create([
            'department_id' => $department->id,
        ]);

        $this->assertEquals($department->name, $position->department->name);
    }
}
