<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrewPositionTest extends TestCase
{
    use RefreshDatabase;

    protected $crew;
    protected $position;
    protected $crewPosition;

    public function setUp()
    {
        parent::setUp();

        $this->crew = factory(Crew::class)->create();
        $this->position = factory(Position::class)->create();
        $this->crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->crew->id,
            'position_id' => $this->position->id
        ]);
    }

    /**
     * @test
     * @covers \App\Models\CrewPosition::crew
     */
    public function crew()
    {
        $this->assertEquals(
            $this->crew->id,
            $this->crewPosition->crew->id
        );
    }

    /**
     * @test
     * @covers \App\Models\CrewPosition::position
     */
    public function position()
    {
        $this->assertEquals(
            $this->position->id,
            $this->crewPosition->position->id
        );
    }

    /**
     * @test
     * @covers \App\Models\CrewPosition::scopeByCrewAndPosition
     */
    public function scopeByCrewAndPosition()
    {
        $this->assertEquals(
            $this->crewPosition->id,
            CrewPosition::byCrewAndPosition($this->crew, $this->position)->first()->id
        );
    }
}
