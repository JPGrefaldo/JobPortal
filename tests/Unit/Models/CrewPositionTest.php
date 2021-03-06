<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\CrewPositionEndorsementScore;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrewPositionTest extends TestCase
{
    use RefreshDatabase;

    protected $crew;
    protected $position;
    protected $crewPosition;

    public function setUp(): void
    {
        parent::setUp();

        $this->crew = factory(Crew::class)->create();
        $this->position = factory(Position::class)->create();
        $this->crewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $this->crew->id,
            'position_id' => $this->position->id,
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
     * @covers \App\Models\CrewPosition::getScoreAttribute
     */
    public function score()
    {
        CrewPositionEndorsementScore::create([
            'crew_position_id' => $this->crewPosition->id,
            'score'            => 25,
        ]);

        $this->assertEquals(
            25,
            $this->crewPosition->score
        );
    }

    /**
     * @test
     * @covers \App\Models\CrewPosition::getScoreAttribute
     */
    public function score_crew_position_does_not_exist()
    {
        $this->assertEquals(
            1,
            $this->crewPosition->score
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
    public function scope_by_crew_and_position()
    {
        $this->assertEquals(
            $this->crewPosition->id,
            CrewPosition::byCrewAndPosition($this->crew, $this->position)->first()->id
        );
    }
}
